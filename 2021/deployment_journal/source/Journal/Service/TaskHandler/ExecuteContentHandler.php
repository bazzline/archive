<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\Journal\Service\TaskHandler;

use Exception;
use Net\Bazzline\Component\Command\Command;
use RuntimeException;

class ExecuteContentHandler implements TaskHandlerInterface
{
    const TEMPORARY_FILE_PREFIX = 'dj_bazzline_';

    /** @var Command */
    private $command;

    /** @var string */
    private $pathToTheTemporaryDirectory;

    /**
     * CommandLineContentHandler constructor.
     *
     * @param Command $command
     */
    public function __construct(
        Command $command
    ) {
        $this->command                      = $command;
        //@todo inject this
        $this->pathToTheTemporaryDirectory  = sys_get_temp_dir();
    }

    /**
     * @param string $content
     * @throws RuntimeException
     */
    public function handle(
        string $content
    ) {
        //begin of dependencies
        $command                        = $this->command;
        $pathToTheTemporaryDirectory    = $this->pathToTheTemporaryDirectory;

        $temporaryFileName  = tempnam(
            $pathToTheTemporaryDirectory,
            self::TEMPORARY_FILE_PREFIX
        );
        //end of dependencies

        //begin of business logic
        try {
            file_put_contents($temporaryFileName, $content);
            chmod($temporaryFileName, 0744);

            $command->execute('./' . $temporaryFileName);

            unlink($temporaryFileName);
        } catch (Exception $exception) {
            throw new RuntimeException(
                sprintf(
                    'could not execute temporary file %s', $temporaryFileName
                ),
                0,
                $exception
            );
        }
        //end of business logic
    }
}