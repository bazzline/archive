<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\UnifiedJournal\Comparator\Service;

use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\CalendarWeekInterface;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\EntityInterface;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\YearInterface;

/**
 * Interface StorageInterface
 * @package Net\Bazzline\DeploymentJournal\UnifiedJournal\Comparator\Storage
 * @todo
 *  if needed, we can implement a browse functionality if number of entries per
 *  calendar week is reaching an amount of entries not able to deal with
 */
interface StorageInterface
{
    /**
     * @param EntityInterface $entry
     */
    public function createEntity(EntityInterface $entry);

    /**
     * @param EntityInterface $entry
     */
    public function deleteEntity(EntityInterface $entry);

    /**
     * @param YearInterface $year
     * @return array|CalendarWeekInterface[]
     */
    public function readListOfCalendarWeeks(YearInterface $year): array;

    /**
     * @param CalendarWeekInterface $calendarWeek
     * @param YearInterface $year
     *
     * @return array|EntityInterface[] - [<uuid> => EntryInterface]
     */
    public function readListOfEntities(CalendarWeekInterface $calendarWeek, YearInterface $year): array;

    /**
     * @return array|YearInterface[]
     */
    public function readListOfYears(): array;
}