<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section;

class LockSectionConfiguration
{
    /** @var string */
    private $filePath;

    /**
     * LockSectionConfiguration constructor.
     *
     * @param string $filePath
     */
    public function __construct(
        string $filePath
    ) {
        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }
}