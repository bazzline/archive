<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-30
 */

namespace Net\Bazzline\Zf\CrontabManaer\Controller\Console;

use Net\Bazzline\Zf\CrontabManaer\Service\CrontabManager;
use Throwable;
use Zend\Console\Adapter\AdapterInterface;

class EnableController extends AbstractController
{
    /** @var AdapterInterface */
    private $console;

    /** @var CrontabManager */
    private $crontabManager;

    /**
     * ListController constructor.
     *
     * @param AdapterInterface $console
     * @param CrontabManager $crontabManager
     */
    public function __construct(
        AdapterInterface $console
        ,CrontabManager $crontabManager
    ) {
        $this->console          = $console;
        $this->crontabManager   = $crontabManager;
    }

    public function fullAction()
    {
        $beVerbose  = $this->beVerbose();
        $response   = $this->getResponse();

        try {
            if ($beVerbose) {
                $this->console->writeLine(':: Enabling full crontab.');
            }
            $this->crontabManager->enableFullCronTab();
            if ($beVerbose) {
                $this->console->writeLine('   Done.');
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

    public function sectionAction()
    {
        $beVerbose  = $this->beVerbose();
        $response   = $this->getResponse();

        try {
            if ($beVerbose) {
                $this->console->writeLine(':: Enabling section crontab.');
            }
            $this->crontabManager->enableSectionCronTab();
            if ($beVerbose) {
                $this->console->writeLine('   Done.');
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