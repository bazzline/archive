<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\Journal\Model;

use Net\Bazzline\DeploymentJournal\UnifiedJournal\Journal\Model\EntryInterface;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\CalendarWeekInterface;

class Entry implements EntryInterface
{
    /** @var CalendarWeekInterface */
    private $calendarWeek;

    /** @var string */
    private $createdAt;

    /** @var string */
    private $createdBy;

    /** @var array|string[] */
    private $listOfAffectedEnvironment;

    /** @var Task */
    private $taskToCommit;

    /** @var null|Task */
    private $taskToRevertOrNull;

    /** @var string */
    private $version;

    /** @var string */
    private $uuid;

    /**
     * EntityInterface constructor.
     *
     * @param CalendarWeekInterface $calendarWeek
     * @param string $createdAt
     * @param string $createdBy
     * @param array|string[] $listOfAffectedEnvironment
     * @param Task $taskToCommit
     * @param string $version
     * @param string $uuid
     * @param null|Task $taskToRevert
     */
    public function __construct(
        CalendarWeekInterface $calendarWeek,
        string $createdAt,
        string $createdBy,
        array $listOfAffectedEnvironment,
        Task $taskToCommit,
        string $version,
        string $uuid,
        Task $taskToRevert = null
    ) {
        $this->calendarWeek                 = $calendarWeek;
        $this->createdAt                    = $createdAt;
        $this->createdBy                    = $createdBy;
        $this->listOfAffectedEnvironment    = $listOfAffectedEnvironment;
        $this->taskToCommit                 = $taskToCommit;
        $this->taskToRevertOrNull           = $taskToRevert;
        $this->version                      = $version;
        $this->uuid                         = $uuid;
    }

    //begin of EntryInterface
    public function isAffectedBy(string $environment): bool
    {
        return in_array(
            $environment,
            $this->listOfAffectedEnvironment
        );
    }

    public function calendarWeek(): CalendarWeekInterface
    {
        return $this->calendarWeek;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }
    //end of EntryInterface

    /**
     * @return string - yyyy-mm-dd hh:ii:ss
     */
    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function createdBy(): string
    {
        return $this->createdBy;
    }

    public function hasTaskToRevert(): bool
    {
        return (!is_null($this->taskToRevertOrNull()));
    }

    /**
     * @return array|string[]
     */
    public function listOfAffectedEnvironment(): array
    {
        return $this->listOfAffectedEnvironment;
    }

    public function taskToCommit(): Task
    {
        return $this->taskToCommit;
    }

    /**
     * @return null|Task
     */
    public function taskToRevertOrNull()
    {
        return $this->taskToRevertOrNull;
    }

    public function version(): string
    {
        return $this->version;
    }
}