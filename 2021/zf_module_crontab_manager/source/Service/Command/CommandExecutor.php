<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Service\Command;

use Psr\Log\LoggerInterface;
use RuntimeException;

class CommandExecutor
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * CommandExecutor constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function executeCommand(
        string $command,
        bool $evaluateReturnCode = true
    ) : array {
        $listOfLine = [];
        $returnCode = null;

        $this->logger->debug(
            sprintf(
                'Executing command >>%s<<.',
                $command
            )
        );
        exec(
            $command,
            $listOfLine,
            $returnCode
        );

        if ($evaluateReturnCode) {
            $this->throwRuntimeExceptionIfReturnCodeIsGreaterZero(
                $command,
                $listOfLine,
                $returnCode
            );
        }

        $this->logger->debug(
            sprintf(
                'Output of command as json >>%s<.',
                json_encode($listOfLine)
            )
        );

        return $listOfLine;
    }

    /**
     * @param string $command
     * @param array $listOfLine
     * @param int $returnCode
     * @throws RuntimeException
     */
    private function throwRuntimeExceptionIfReturnCodeIsGreaterZero(
        string $command,
        array $listOfLine,
        int $returnCode
    ) {
        if ($returnCode > 0) {
            $message = sprintf(
                'Return code of >>%d<< caught when executing command >>%s<<. Dumping returned content as json >>%s<<.',
                $returnCode,
                $command,
                json_encode($listOfLine)
            );

            $this->logger->alert($message);

            throw new RuntimeException($message);
        }
    }
}