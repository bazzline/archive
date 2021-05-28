<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Service;

use InvalidArgumentException;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Configuration;
use Net\Bazzline\Zf\CrontabManaer\Service\Crontab\CrontabService;
use Net\Bazzline\Zf\CrontabManaer\Service\Crontab\SectionManager;
use Net\Bazzline\Zf\CrontabManaer\Service\LockFile\LockFile;
use Net\Bazzline\Zf\CrontabManaer\Service\Storage\FileStorage;
use Net\Bazzline\Zf\CrontabManaer\Service\Template\Renderer;
use Psr\Log\LoggerInterface;
use RuntimeException;

class CrontabManager
{
    const COMMENT_PREFIX_IDENTIFIER = '#CrontabManager::';

    /** @var CrontabService */
    private $crontabService;

    /** @var string */
    private $filePathFullDump;

    /** @var string */
    private $filePathSectionDump;

    /** @var string */
    private $filePathSectionRendered;

    /** @var string */
    private $filePathTemplate;

    /** @var string */
    private $filePathUpdatedDump;

    /** @var FileStorage */
    private $fileStorage;

    /** @var array */
    private $listOfTemplateKeyToValue;

    /** @var LockFile */
    private $lockFile;

    /** @var LoggerInterface */
    private $logger;

    /** @var Renderer */
    private $renderer;

    /** @var SectionManager */
    private $sectionManager;

    public function __construct(
        Configuration $configuration,
        CrontabService $crontabService,
        FileStorage $fileStorage,
        LockFile $lockFile,
        Renderer $renderer,
        SectionManager $sectionManager
    ) {
        $this->crontabService   = $crontabService;
        $this->fileStorage      = $fileStorage;
        $this->lockFile         = $lockFile;
        $this->renderer         = $renderer;
        $this->sectionManager   = $sectionManager;

        $this->logger   = $configuration->getLoggerInterface();

        $this->filePathFullDump         = $configuration->getDumpSectionConfiguration()->getFilePathFullDump();
        $this->filePathSectionDump      = $configuration->getDumpSectionConfiguration()->getFilePathSectionDump();
        $this->filePathTemplate         = $configuration->getTemplateSectionConfiguration()->getFilePathTemplate();
        $this->filePathSectionRendered  = $configuration->getTemplateSectionConfiguration()->getFilePathRenderedTemplate();
        $this->filePathUpdatedDump      = $configuration->getDumpSectionConfiguration()->getFilePathUpdatedDump();

        $this->listOfTemplateKeyToValue = $configuration->getTemplateSectionConfiguration()->getListOfTemplateKeyToValue();
    }

    /**
     * @return array $listOfLineOfDifference - if empty, no difference exist
     * @throws RuntimeException
     */
    public function audit() : array
    {
        $this->logger->info('Starting audit.');
        $dumpFullCronTab        = (!file_exists($this->filePathFullDump));
        $dumpSectionCronTab     = (!file_exists($this->filePathSectionDump));
        $listOfLineOfDifference = [];

        if ($dumpFullCronTab) {
            $this->createCrontabFullDump();
        }

        if ($dumpSectionCronTab) {
            $this->createSectionDump();
        }

        $this->renderSectionTemplate();

        $this->logger->debug(
            sprintf(
                'Creating diff from file one >>%s<< and file to >>%s<<.',
                $this->filePathSectionDump,
                $this->filePathSectionRendered
            )
        );

        foreach ($this->fileStorage->diff($this->filePathSectionDump, $this->filePathSectionRendered) as $line) {
            $listOfLineOfDifference[] = $line;
        }

        return $listOfLineOfDifference;
    }

    public function disableFullCronTab()
    {
        $this->logger->info('Disable full cron tab.');
        $this->lockFile->acquire();
        $this->crontabService->dumpAll($this->filePathFullDump);
        $listOfUpdatedLine = array_map(
                function (string $line) {
                    //check if line starts with special prefix
                    //  only comment out needed lines
                    if (strncmp($line, self::COMMENT_PREFIX_IDENTIFIER, strlen(self::COMMENT_PREFIX_IDENTIFIER)) === 0) {
                        return $line;
                    } else {
                        return self::COMMENT_PREFIX_IDENTIFIER . $line;
                    }
                },
                $this->fileStorage->readFileAsArray($this->filePathFullDump)
        );

        $this->fileStorage->writeToFileFromArray(
            $this->filePathUpdatedDump,
            $listOfUpdatedLine
        );

        $this->loadUpdatedCronTab();
        $this->lockFile->release();
    }

    public function disableSectionCronTab()
    {
        $this->logger->info('Disable section cron tab.');
        $this->lockFile->acquire();
        $this->crontabService->dumpAll($this->filePathFullDump);
        $this->createSectionCronTag();
        $listOfUpdatedLine = $this->sectionManager->replaceSectionContent(
            $this->fileStorage->readFileAsArray($this->filePathFullDump),
            array_map(
                function (string $line) {
                    //check if line starts with special prefix
                    //  only comment out needed lines
                    if (strncmp($line, self::COMMENT_PREFIX_IDENTIFIER, strlen(self::COMMENT_PREFIX_IDENTIFIER)) === 0) {
                        return $line;
                    } else {
                        return self::COMMENT_PREFIX_IDENTIFIER . $line;
                    }
                },
                $this->fileStorage->readFileAsArray($this->filePathSectionRendered)
            )
        );

        $this->fileStorage->writeToFileFromArray(
            $this->filePathUpdatedDump,
            $listOfUpdatedLine
        );

        $this->loadUpdatedCronTab();
        $this->lockFile->release();
    }

    public function enableFullCronTab()
    {
        $this->logger->info('Enable full cron tab.');
        $this->lockFile->acquire();
        $this->loadFullCronTab();
        $this->lockFile->release();
    }

    public function enableSectionCronTab()
    {
        $this->logger->info('Enable section cron tab.');
        $this->lockFile->acquire();
        $this->updateIfNeeded();
        $this->loadUpdatedCronTab();
        $this->lockFile->release();
    }

    public function listFullCronTab() : array
    {
        $this->logger->info('Reading full cron tab.');
        return $this->crontabService->read();
    }

    public function listSectionCronTab() : array
    {
        $this->logger->info('Reading section cron tab.');
        return $this->sectionManager->sliceSection(
            $this->crontabService->read()
        );
    }

    /**
     * @throws RuntimeException
     */
    public function updateIfNeeded()
    {
        $this->logger->info('Starting updateIfNeeded.');

        $listOfLineOfDifference = $this->audit();

        if (!empty($listOfLineOfDifference)) {
            $this->logger->info('There is a difference between section dump and rendered template.');
            $this->logger->debug('Dumping lines of differences.');
            foreach ($listOfLineOfDifference as $lineOfDifference) {
                $this->logger->debug('   ' . $lineOfDifference);
            }

            $this->update();
        } else {
            $this->logger->info('No updateIfNeeded needed.');
        }
    }

    /**
     * @throws RuntimeException
     */
    public function update()
    {
        $this->logger->info('Starting update.');
        $this->lockFile->acquire();

        $this->logger->debug(
            sprintf(
                'Creating file >>%s<<.',
                $this->filePathUpdatedDump
            )
        );
        $listOfUpdatedLine = $this->sectionManager->replaceSectionContent(
            $this->fileStorage->readFileAsArray($this->filePathFullDump),
            $this->fileStorage->readFileAsArray($this->filePathSectionRendered)
        );

        $this->fileStorage->writeToFileFromArray(
            $this->filePathUpdatedDump,
            $listOfUpdatedLine
        );

        $this->lockFile->release();
    }

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    private function loadFullCronTab()
    {
        $this->crontabService->load(
            $this->filePathFullDump
        );
    }

    /**
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    private function loadUpdatedCronTab()
    {
        $this->crontabService->load(
            $this->filePathUpdatedDump
        );
    }

    private function createCrontabFullDump()
    {
        $this->logger->debug('Dumping full cron tab.');
        $this->logger->debug(
            sprintf(
                'Creating file >>%s<<.',
                $this->filePathFullDump
            )
        );
        $this->crontabService->dumpAll($this->filePathFullDump);
    }

    private function createSectionDump()
    {
        $this->logger->debug('Dumping section cron tab.');
        $this->logger->debug(
            sprintf(
                'Creating file >>%s<<.',
                $this->filePathSectionDump
            )
        );
        $this->createSectionCronTag();
    }

    /**
     * @throws RuntimeException
     */
    private function createSectionCronTag()
    {
        $listOfAllLine = $this->fileStorage->readFileAsArray(
            $this->filePathFullDump
        );

        $listOfSectionLine = $this->sectionManager->sliceSection(
            $listOfAllLine
        );

        $this->fileStorage->writeToFileFromArray(
            $this->filePathSectionDump,
            $listOfSectionLine
        );
    }

    /**
     * @throws RuntimeException
     */
    private function renderSectionTemplate()
    {
        $this->logger->debug('Rendering section template.');
        $this->logger->debug(
            sprintf(
                'Creating file >>%s<<.',
                $this->filePathSectionRendered
            )
        );

        $this->fileStorage->writeToFileFromString(
            $this->renderer->render(
                $this->listOfTemplateKeyToValue,
                $this->fileStorage->readFileAsString(
                    $this->filePathTemplate
                )
            ),
            $this->filePathSectionRendered
        );
    }
}