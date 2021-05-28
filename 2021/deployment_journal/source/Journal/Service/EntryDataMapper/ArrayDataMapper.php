<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\Journal\Service\EntryDataMapper;

use Interop\Container\ContainerInterface;
use InvalidArgumentException;
use Net\Bazzline\DeploymentJournal\Journal\Model\Entry;
use Net\Bazzline\DeploymentJournal\Journal\Model\Task;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\CalendarWeek;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\Year;

class ArrayDataMapper implements EntryDataMapperInterface
{
    /** @var ContainerInterface */
    private $container;

    /** @return string */
    public function identifier()
    {
        return 'array.php';
    }

    /**
     * @param Entry $entry
     * @return array
     */
    public function mapFromEntryToData(
        Entry $entry
    ) {
        //begin of dependencies
        $listOfAffectedEnvironment  = [];
        $taskTodo                   = $entry->taskToCommit();
        $taskUndo                   = $entry->taskToRevertOrNull();
        //end of dependencies

        //begin of business logic
        foreach ($entry->listOfAffectedEnvironment() as $environment) {
            $listOfAffectedEnvironment[] = [
                self::DATA_KEY_ENVIRONMENT_NAME         => $environment
            ];
        }

        if ($entry->hasTaskToRevert()) {
            $array = [
                self::DATA_KEY_UUID                         => $entry->uuid(),
                self::DATA_KEY_CREATED_AT                   => $entry->createdAt(),
                self::DATA_KEY_CREATED_BY                   => $entry->createdBy(),
                self::DATA_KEY_LIST_OF_AFFECTED_ENVIRONMENT => $listOfAffectedEnvironment,
                self::DATA_KEY_NAME                         => $entry->name(),
                self::DATA_KEY_TASK_TO_COMMIT                    => [
                    self::DATA_KEY_TASK_CLASS_NAME_OF_HANDLER   => get_class($taskTodo->handler()),
                    self::DATA_KEY_TASK_CONTENT                 => $taskTodo->content(),
                    self::DATA_KEY_TASK_DESCRIPTION             => $taskTodo->description()
                ],
                self::DATA_KEY_TASK_TO_REVERT                    => [
                    self::DATA_KEY_TASK_CLASS_NAME_OF_HANDLER   => get_class($taskUndo->handler()),
                    self::DATA_KEY_TASK_CONTENT                 => $taskUndo->content(),
                    self::DATA_KEY_TASK_DESCRIPTION             => $taskUndo->description()
                ],
                self::DATA_KEY_CALENDAR_WEEK                => $entry->calendarWeek()->toString(),
                self::DATA_KEY_CALENDAR_WEEK                => $entry->calendarWeek()->year()->toString(),
                self::DATA_KEY_VERSION                      => self::CURRENT_VERSION
            ];
        } else {
            $array = [
                self::DATA_KEY_UUID                         => $entry->uuid(),
                self::DATA_KEY_CREATED_AT                   => $entry->createdAt(),
                self::DATA_KEY_CREATED_BY                   => $entry->createdBy(),
                self::DATA_KEY_LIST_OF_AFFECTED_ENVIRONMENT => $listOfAffectedEnvironment,
                self::DATA_KEY_TASK_TO_COMMIT                    => [
                    self::DATA_KEY_TASK_CLASS_NAME_OF_HANDLER   => get_class($taskTodo->handler()),
                    self::DATA_KEY_TASK_CONTENT                 => $taskTodo->content(),
                    self::DATA_KEY_TASK_DESCRIPTION             => $taskTodo->description()
                ],
                null,
                self::DATA_KEY_CALENDAR_WEEK                => $entry->calendarWeek()->toString(),
                self::DATA_KEY_CALENDAR_WEEK                => $entry->calendarWeek()->year()->toString(),
                self::DATA_KEY_VERSION                      => self::CURRENT_VERSION
            ];
        }

        return $array;
        //end of business logic
    }

    /**
     * @param mixed $data
     *
     * @return Entry
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function mapFromDataToEntry(
        $data
    ): Entry {
        //begin of dependencies
        $container = $this->container;
        //end of dependencies

        //begin of business logic
        if (!is_array($data)) {
            //@todo - check for all mandatory properties?
            throw new InvalidArgumentException(
                'Data must be an array'
            );
        }

        $calendarWeek               = new CalendarWeek(
            $data[self::DATA_KEY_CALENDAR_WEEK],
            new Year(
                $data[self::DATA_KEY_YEAR]
            )
        );
        $listOfAffectedEnvironment  = $data[self::DATA_KEY_LIST_OF_AFFECTED_ENVIRONMENT];

        return new Entry(
            $calendarWeek,
            $data[self::DATA_KEY_CREATED_AT],
            $data[self::DATA_KEY_CREATED_BY],
            $listOfAffectedEnvironment,
            new Task(
                $data[self::DATA_KEY_TASK_TO_COMMIT][self::DATA_KEY_TASK_CONTENT],
                $data[self::DATA_KEY_TASK_TO_COMMIT][self::DATA_KEY_TASK_DESCRIPTION],
                $container->get(
                    $data[self::DATA_KEY_TASK_TO_COMMIT][self::DATA_KEY_TASK_CLASS_NAME_OF_HANDLER]
                )
            ),
            (
                isset($data[self::DATA_KEY_TASK_TO_REVERT])
                ? new Task(
                    $data[self::DATA_KEY_TASK_TO_REVERT][self::DATA_KEY_TASK_CONTENT],
                    $data[self::DATA_KEY_TASK_TO_REVERT][self::DATA_KEY_TASK_DESCRIPTION],
                    $container->get(
                        $data[self::DATA_KEY_TASK_TO_REVERT][self::DATA_KEY_TASK_CLASS_NAME_OF_HANDLER]
                    )
                )
                : null
            ),
            $data[self::DATA_KEY_VERSION],
            $data[self::DATA_KEY_UUID]
        );
        //end of business logic
    }
}