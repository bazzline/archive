<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-09-01
 */

namespace Net\Bazzline\DeploymentJournal\Service\Process;

use RuntimeException;

interface ExecutableInterface
{
    /**
     * @throws RuntimeException
     */
    public function execute();
}