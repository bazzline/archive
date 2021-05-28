<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Service\LockFile;

use Psr\Log\LoggerInterface;
use RuntimeException;

class LockFile
{
    /** @var string */
    private $filePath;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        string $filePath,
        LoggerInterface $logger
    ) {
        $this->filePath = $filePath;
        $this->logger   = $logger;
    }

    public function exists() : bool
    {
        return file_exists($this->filePath);
    }

    public function acquire()
    {
        if ($this->exists()) {
            throw new RuntimeException(
                sprintf(
                    'Can not acquire lock, file exists in the path >>%s<<.',
                    $this->filePath
                )
            );
        }

        $content = sprintf(
            'Created by pid >>%d<< at >>%s<<.',
            getmypid(),
            date('Y-m-d H:i:s')
        );

        if (file_put_contents(
            $this->filePath,
            $content
        )) {
            $this->logger->debug(
                sprintf(
                    'Created lock file in path >>%s<<.',
                    $this->filePath
                )
            );
        } else {
            throw new RuntimeException(
                sprintf(
                    'Could not create lock file in path >>%s<<.',
                    $this->filePath
                )
            );
        }
    }

    public function release()
    {
        if ($this->exists()) {
            if (unlink($this->filePath)) {
                $this->logger->debug(
                    sprintf(
                        'Removed lock file in path >>%s<<.',
                        $this->filePath
                    )
                );
            } else {
                throw new RuntimeException(
                    sprintf(
                        'Could not remove lock file in path >>%s<<.',
                        $this->filePath
                    )
                );
            }
        }
    }
}