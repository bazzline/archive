<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model;

class Year implements YearInterface
{
    /** @var string */
    private $year;

    /**
     * Year constructor.
     *
     * @param string $year
     */
    public function __construct(
        string $year
    ) {
        $this->year = $year;
    }

    public function toString(): string
    {
        return $this->year;
    }
}