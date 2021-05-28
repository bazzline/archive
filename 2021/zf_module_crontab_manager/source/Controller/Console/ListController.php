<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-24
 */

namespace Net\Bazzline\Zf\CrontabManaer\Controller\Console;

use Net\Bazzline\Zf\CrontabManaer\Service\CrontabManager;
use Throwable;
use Zend\Console\Adapter\AdapterInterface;

class ListController extends AbstractController
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
        $response   = $this->getResponse();

        try {
            foreach ($this->crontabManager->listFullCronTab() as $line) {
                $this->console->write($line);
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
        $response   = $this->getResponse();

        try {
            foreach ($this->crontabManager->listSectionCronTab() as $line) {
                $this->console->write($line);
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