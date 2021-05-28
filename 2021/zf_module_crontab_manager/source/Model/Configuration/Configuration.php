<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Model\Configuration;

use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\DumpSectionConfiguration;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\LockSectionConfiguration;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\TemplateSectionConfiguration;
use Psr\Log\LoggerInterface;

class Configuration
{
    /** @var DumpSectionConfiguration */
    private $dumpSectionConfiguration;

    /** @var LockSectionConfiguration */
    private $lockSectionConfiguration;

    /** @var LoggerInterface */
    private $loggerInterface;

    /** @var TemplateSectionConfiguration */
    private $templateSectionConfiguration;

    public function __construct(
        DumpSectionConfiguration $dumpSectionConfiguration,
        LockSectionConfiguration $lockSectionConfiguration,
        LoggerInterface $logger,
        TemplateSectionConfiguration $templateSectionConfiguration
    ) {
        $this->dumpSectionConfiguration     = $dumpSectionConfiguration;
        $this->lockSectionConfiguration     = $lockSectionConfiguration;
        $this->loggerInterface              = $logger;
        $this->templateSectionConfiguration = $templateSectionConfiguration;
    }

    /**
     * @return DumpSectionConfiguration
     */
    public function getDumpSectionConfiguration(): DumpSectionConfiguration
    {
        return $this->dumpSectionConfiguration;
    }

    /**
     * @return LockSectionConfiguration
     */
    public function getLockSectionConfiguration(): LockSectionConfiguration
    {
        return $this->lockSectionConfiguration;
    }

    /**
     * @return LoggerInterface
     */
    public function getLoggerInterface(): LoggerInterface
    {
        return $this->loggerInterface;
    }

    /**
     * @return TemplateSectionConfiguration
     */
    public function getTemplateSectionConfiguration(): TemplateSectionConfiguration
    {
        return $this->templateSectionConfiguration;
    }
}