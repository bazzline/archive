<?php

declare(strict_types=1);

namespace Net\Bazzline\Zf\CrontabManaer;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\Stdlib\Glob;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Module
 */
class Module
{
    /**
     * @return array
     * @throws \Zend\Stdlib\Exception\RuntimeException
     */
    public function getConfig() : array
    {
        $configuration = [];

        foreach (Glob::glob(__DIR__ . '/../config/{,*.}config.php', Glob::GLOB_BRACE) as $file) {
            $fileContent = include $file;
            $fileArray = is_array($fileContent) ? $fileContent : [];
            $configuration = ArrayUtils::merge($configuration, $fileArray);
        }

        return $configuration;
    }



    /**
     * @param Console $console
     * @return array
     */
    public function getConsoleUsage(Console $console) : array
    {
        return [
            //alphabetically order!
            'crawler-manager audit [-v]'            => 'Checks if an updateIfNeeded is needed.',
            'crawler-manager disable full [-v]'     => 'Disables full crontab.',
            'crawler-manager disable section [-v]'  => 'Disables section crontab.',
            'crawler-manager enable full [-v]'      => 'Enable full crontab.',
            'crawler-manager enable section [-v]'   => 'Enable section crontab.',
            'crawler-manager list full'             => 'Displays full crontab to the command line.',
            'crawler-manager section full'          => 'Displays managed section crontab to the command line.',
            'crawler-manager update  [-f] [-v]'     => 'Updates the crontab if needed.',

        ];
    }
}
