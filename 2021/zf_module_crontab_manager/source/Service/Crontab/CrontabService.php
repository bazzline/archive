<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Service\Crontab;

use InvalidArgumentException;
use Net\Bazzline\Zf\CrontabManaer\Service\Command\CommandExecutor;
use Net\Bazzline\Zf\CrontabManaer\Service\Storage\FileStorage;
use Psr\Log\LoggerInterface;

class CrontabService
{
    /** @var CommandExecutor */
    private $commandExecutor;

    /** @var LoggerInterface */
    private $logger;

    /** @var FileStorage */
    private $fileStorage;

    /**
     * CrontabService constructor.
     *
     * @param CommandExecutor $commandExecutor
     * @param FileStorage $fileStorage
     * @param LoggerInterface $logger
     */
    public function __construct(
        CommandExecutor $commandExecutor,
        FileStorage $fileStorage,
        LoggerInterface $logger
    ) {
        $this->commandExecutor  = $commandExecutor;
        $this->fileStorage      = $fileStorage;
        $this->logger           = $logger;
    }

    public function deleteAll()
    {
        $command = '/usr/bin/env crontab -r';

        $this->logger->debug('Deleting whole crontab.');
        $this->commandExecutor->executeCommand($command);
    }

    public function disableAll()
    {
        $this->logger->debug('Disable whole crontab.');
        $command            = '/usr/bin/env crontab -l';
        $temporaryFilePath  = tempnam(
            sys_get_temp_dir(),
            'ctm_'
        );

        $listOfLine = array_map(
            function (string $line) {
                return '#' . $line;
            },
            $this->commandExecutor->executeCommand($command)
        );

        $this->fileStorage->writeToFileFromArray(
            $temporaryFilePath,
            $listOfLine
        );

        $this->load(
            $temporaryFilePath
        );
    }

    /**
     * @param string $destinationFilePath
     */
    public function dumpAll(
        string $destinationFilePath
    ) {
        $this->fileStorage->writeToFileFromArray(
            $destinationFilePath,
            $this->read()
        );
    }

    /**
     * @param string $sourceFilePath
     * @throws InvalidArgumentException
     */
    public function load(
        string $sourceFilePath
    ) {
        $this->logger->debug('Creating crontab.');
        if (file_exists($sourceFilePath)) {
            $command    = '/usr/bin/env crontab ' . $sourceFilePath;

            $this->commandExecutor->executeCommand(
                $command
            );
        } else {
            throw new InvalidArgumentException(
                sprintf(
                    'Provided file path >>%s<< does not exist.',
                    $sourceFilePath
                )
            );
        }
    }

    public function read() : array
    {
        $this->logger->debug('Dumping whole cron tab.');
        $command = '/usr/bin/env crontab -l';

        return $this->commandExecutor->executeCommand($command);
    }
}