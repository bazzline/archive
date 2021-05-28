<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model;

class CalendarWeek implements CalendarWeekInterface
{
    /** @var string */
    private $calendarWeek;

    /** @var YearInterface */
    private $year;

    /**
     * CalendarWeek constructor.
     *
     * @param string $calendarWeek
     * @param YearInterface $year
     */
    public function __construct(
        string $calendarWeek,
        YearInterface $year
    ) {
        $this->calendarWeek = $calendarWeek;
        $this->year         = $year;
    }

    public function toString(): string
    {
        return $this->calendarWeek;
    }

    public function year(): YearInterface
    {
        return $this->year;
    }
}