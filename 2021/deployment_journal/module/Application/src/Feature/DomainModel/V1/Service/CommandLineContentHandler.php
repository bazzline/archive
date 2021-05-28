<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-08-31
 */

namespace Application\Feature\DomainModel\V1\Service;

use Exception;
use Net\Bazzline\Component\Command\Command;
use RuntimeException;

class CommandLineContentHandler implements TaskContentHandlerInterface
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
    public function handle($content)
    {
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

            $command->execute($temporaryFileName);

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