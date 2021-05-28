<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\Dump;

class ArchiverDumpSectionConfiguration
{
    /** @var bool */
    private $archiveFullDump;

    /** @var int */
    private $numberOfFullDumpsToKeep;

    /**
     * ArchiverDumpSectionConfiguration constructor.
     *
     * @param bool $archiveFullDump
     * @param int $numberOfFullDumpsToKeep
     */
    public function __construct(
        bool $archiveFullDump,
        int $numberOfFullDumpsToKeep
    ) {
        $this->archiveFullDump          = $archiveFullDump;
        $this->numberOfFullDumpsToKeep  = $numberOfFullDumpsToKeep;
    }

    /**
     * @return bool
     */
    public function isArchiveFullDump(): bool
    {
        return $this->archiveFullDump;
    }

    /**
     * @return int
     */
    public function getNumberOfFullDumpsToKeep(): int
    {
        return $this->numberOfFullDumpsToKeep;
    }
}