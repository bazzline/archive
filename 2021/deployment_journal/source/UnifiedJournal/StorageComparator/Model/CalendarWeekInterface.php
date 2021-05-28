<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model;

interface CalendarWeekInterface
{
    public function toString(): string;

    public function year(): YearInterface;
}