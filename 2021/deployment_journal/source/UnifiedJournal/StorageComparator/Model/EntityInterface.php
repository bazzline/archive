<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model;

interface EntityInterface
{
    public function calendarWeek(): CalendarWeekInterface;

    public function uuid(): string;
}