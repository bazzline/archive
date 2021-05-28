<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\Journal\Service\TaskHandler;

interface TaskHandlerInterface
{
    /**
     * @param string $content
     */
    public function handle(
        string $content
    );
}