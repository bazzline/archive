<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-08-31
 */

namespace Application\Feature\DomainModel\V1\Model;

class Entry
{
    /** @var string */
    private $createdAt;

    /** @var string */
    private $createdBy;

    /** @var array|Environment[] */
    private $listOfAffectedEnvironment;

    /** @var string */
    private $name;

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
     * @param string $createdAt
     * @param string $createdBy
     * @param array $listOfAffectedEnvironment
     * @param string $name
     * @param Task $taskToCommit
     * @param null|Task $taskToRevert
     * @param string $version
     * @param string $uuid
     */
    public function __construct(
        $createdAt,
        $createdBy,
        array $listOfAffectedEnvironment,
        string $name,
        Task $taskToCommit,
        Task $taskToRevert = null,
        $version,
        $uuid
    ) {
        $this->createdAt                    = $createdAt;
        $this->createdBy                    = $createdBy;
        $this->listOfAffectedEnvironment    = $listOfAffectedEnvironment;
        $this->name                         = $name;
        $this->taskToCommit                 = $taskToCommit;
        $this->taskToRevertOrNull           = $taskToRevert;
        $this->version                      = $version;
        $this->uuid                         = $uuid;
    }

    /**
     * @return string - yyyy-mm-dd hh:ii:ss
     */
    public function createdAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function createdBy()
    {
        return $this->createdBy;
    }

    /**
     * @return bool
     */
    public function hasTaskToRevert()
    {
        return (!is_null($this->taskToRevertOrNull()));
    }

    /**
     * @return array|Environment[]
     */
    public function listOfAffectedEnvironment()
    {
        return $this->listOfAffectedEnvironment;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return Task
     */
    public function taskToCommit()
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

    /**
     * @return string
     */
    public function version()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function uuid()
    {
        return $this->uuid;
    }
}