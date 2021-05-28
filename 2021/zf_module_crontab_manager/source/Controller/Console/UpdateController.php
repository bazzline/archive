<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-24
 */

namespace Net\Bazzline\Zf\CrontabManaer\Controller\Console;

use Net\Bazzline\Zf\CrontabManaer\Service\CrontabManager;
use Throwable;
use Zend\Console\Adapter\AdapterInterface;

class UpdateController extends AbstractController
{
    /** @var AdapterInterface */
    private $console;

    /** @var CrontabManager */
    private $crontabManager;

    /**
     * UpdateController constructor.
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
        $isForced   = $this->isForced();
        $response   = $this->getResponse();

        if ($beVerbose) {
            $this->console->writeLine(':: Updating current crontab.');
        }

        try {
            if ($isForced) {
                $this->console->writeLine('  Update is forced.');
                $this->crontabManager->update();
            } else {
                $this->crontabManager->updateIfNeeded();
            }
        } catch (Throwable $throwable) {
            $this->handleThrowable(
                $this->console,
                $response,
                $throwable
            );
        }

        if ($beVerbose) {
            $this->console->writeLine('   Done.');
            $this->console->writeLine(':: Dumping current crontab.');
            foreach ($this->crontabManager->listFullCronTab() as $line) {
                $this->console->writeLine('   ' . $line);
            }
        }

        return $response;
    }
}