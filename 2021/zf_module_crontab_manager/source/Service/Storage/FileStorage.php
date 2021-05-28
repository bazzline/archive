<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Service\Storage;

use Net\Bazzline\Zf\CrontabManaer\Service\Command\CommandExecutor;
use Psr\Log\LoggerInterface;
use RuntimeException;

class FileStorage
{
    /** @var CommandExecutor */
    private $commandExecutor;

    /** @var LoggerInterface */
    private $logger;

    /**
     * FileStorage constructor.
     *
     * @param CommandExecutor $commandExecutor
     * @param LoggerInterface $logger
     */
    public function __construct(
        CommandExecutor $commandExecutor,
        LoggerInterface $logger
    ) {
        $this->commandExecutor  = $commandExecutor;
        $this->logger           = $logger;
    }

    public function diff(
        string $filePathOne,
        string $filePathTwo
    ) : array {
        $this->logger->debug(
            sprintf(
                'Creating diff from file one >>%s<< and file to >>%s<<.',
                $filePathOne,
                $filePathTwo
            )
        );

        $command = '/usr/bin/env diff ' . $filePathOne . ' ' . $filePathTwo;

        $listOfLine = $this->commandExecutor->executeCommand(
            $command,
            false
        );

        return $listOfLine;
    }

    /**
     * @param string $filePath
     * @return array
     * @throws RuntimeException
     */
    public function readFileAsArray(
        string $filePath
    ) : array {
        $contentAsString = $this->readFileAsString(
            $filePath
        );

        $contentAsArray = explode(
            PHP_EOL,
            $contentAsString
        );

        return $contentAsArray;
    }

    /**
     * @param string $filePath
     * @return string
     * @throws RuntimeException
     */
    public function readFileAsString(
        string $filePath
    ) : string {
        $contentOrFalse = file_get_contents($filePath);

        if ($contentOrFalse === false) {
            throw new RuntimeException(
                sprintf(
                    'Could not read content of file path >>%s<<.',
                    $filePath
                )
            );
        }

        return $contentOrFalse;
    }

    /**
     * @param string $filePath
     * @param array $listOfLine
     */
    public function writeToFileFromArray(
        string $filePath,
        array $listOfLine
    ) {
        $this->writeToFileFromString(
            implode(
                PHP_EOL,
                $listOfLine
            ),
            $filePath
        );
    }

    /**
     * @param string $content
     * @param string $filePath
     * @throws RuntimeException
     */
    public function writeToFileFromString(
        string $content,
        string $filePath
    ) {
        $return = file_put_contents(
            $filePath,
            $content
        );

        if ($return === false) {
            throw new RuntimeException(
                sprintf(
                    'Could not write content to file path >>%s<<.',
                    $filePath
                )
            );
        }
    }
}