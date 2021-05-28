<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\Journal\Service\TaskHandler;

class OutputContentHandler implements TaskHandlerInterface
{
    /**
     * @param string $content
     */
    public function handle(
        string $content
    ) {
        //begin of business logic
        foreach (explode(PHP_EOL, $content) as $line) {
            echo $line . PHP_EOL;
        }
        //end of business logic
    }
}