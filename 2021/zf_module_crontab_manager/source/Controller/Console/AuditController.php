<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-24
 */

namespace Net\Bazzline\Zf\CrontabManaer\Controller\Console;

use Net\Bazzline\Zf\CrontabManaer\Service\CrontabManager;
use Throwable;
use Zend\Console\Adapter\AdapterInterface;

class AuditController extends AbstractController
{
    /** @var AdapterInterface */
    private $console;

    /** @var CrontabManager */
    private $crontabManager;

    /**
     * AuditController constructor.
     *
     * @param AdapterInterface $console
     * @param CrontabManager $crontabManager
     */
    public function __construct(
        AdapterInterface $console,
        CrontabManager $crontabManager
    ) {
        $this->console          = $console;
        $this->crontabManager   = $crontabManager;
    }

    public function indexAction()
    {
        $beVerbose  = $this->beVerbose();
        $response   = $this->getResponse();

        if ($beVerbose) {
            $this->console->writeLine(':: Auditing current crontab.');
        }

        try {
            $listOfDifferentLine = $this->crontabManager->audit();

            if (empty($listOfDifferentLine)) {
                if ($beVerbose) {
                    $this->console->writeLine('   All is fine.');
                }
            } else {
                if ($beVerbose) {
                    $this->console->writeLine('   An updateIfNeeded is needed.');
                    $this->console->writeLine(':: Dumping difference.');
                    foreach ($listOfDifferentLine as $lineOfDifference) {
                        $this->console->writeLine('   ' . $lineOfDifference);
                    }
                }
                $response->setErrorLevel(1);
            }
        } catch (Throwable $throwable) {
            $this->handleThrowable(
                $this->console,
                $response,
                $throwable
            );
        }

        return $response;
    }
}