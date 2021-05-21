<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2018-05-11
 */

namespace Net\Bazzline\Php\Zend\ConsolePsrLogger\Model;

use Psr\Log\LoggerInterface;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\ColorInterface;

class ZendConsolePsrLogger implements LoggerInterface
{
    /** @var AdapterInterface */
    private $console;

    /**
     * ZendConsoleAdapter constructor.
     *
     * @param AdapterInterface $console
     */
    public function __construct(
        AdapterInterface $console
    ) {
        $this->console = $console;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function emergency($message, array $context = [])
    {
        $this->console->writeLine($message, ColorInterface::RED);
    }

    /**
     * Action must be taken immediately.
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function alert($message, array $context = [])
    {
        $this->console->writeLine($message, ColorInterface::LIGHT_RED);
    }

    /**
     * Critical conditions.
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function critical($message, array $context = [])
    {
        $this->console->writeLine($message, ColorInterface::YELLOW);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function error($message, array $context = [])
    {
        $this->console->writeLine($message, ColorInterface::MAGENTA);
    }

    /**
     * Exceptional occurrences that are not errors.
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function warning($message, array $context = [])
    {
        $this->console->writeLine($message, ColorInterface::LIGHT_MAGENTA);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function notice($message, array $context = [])
    {
        $this->console->writeLine($message, ColorInterface::GREEN);
    }

    /**
     * Interesting events.
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function info($message, array $context = [])
    {
        $this->console->writeLine($message, ColorInterface::LIGHT_GREEN);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    public function debug($message, array $context = [])
    {
        $this->console->writeLine($message, ColorInterface::LIGHT_WHITE);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        $this->console->writeLine($message, ColorInterface::NORMAL);
    }
}
