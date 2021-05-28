<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section;

use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\Dump\ArchiverDumpSectionConfiguration;

class DumpSectionConfiguration
{
    /** @var ArchiverDumpSectionConfiguration */
    private $archiverDumpSectionConfiguration;

    /** @var string */
    private $filePathFullDump;

    /** @var string */
    private $filePathSectionDump;

    /** @var string */
    private $filePathUpdatedDump;

    /**
     * DumpSectionConfiguration constructor.
     *
     * @param ArchiverDumpSectionConfiguration $archiverConfiguration
     * @param string $filePathFullDump
     * @param string $filePathSectionDump
     * @param string $filePathUpdatedDump
     */
    public function __construct(
        ArchiverDumpSectionConfiguration $archiverConfiguration,
        string $filePathFullDump,
        string $filePathSectionDump,
        string $filePathUpdatedDump
    ) {
        $this->archiverDumpSectionConfiguration = $archiverConfiguration;
        $this->filePathFullDump                 = $filePathFullDump;
        $this->filePathSectionDump              = $filePathSectionDump;
        $this->filePathUpdatedDump              = $filePathUpdatedDump;
    }

    /**
     * @return ArchiverDumpSectionConfiguration
     */
    public function getArchiverDumpSectionConfiguration(): ArchiverDumpSectionConfiguration
    {
        return $this->archiverDumpSectionConfiguration;
    }

    /**
     * @return string
     */
    public function getFilePathFullDump(): string
    {
        return $this->filePathFullDump;
    }

    /**
     * @return string
     */
    public function getFilePathSectionDump(): string
    {
        return $this->filePathSectionDump;
    }

    /**
     * @return string
     */
    public function getFilePathUpdatedDump(): string
    {
        return $this->filePathUpdatedDump;
    }
}