<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-08-31
 */

namespace Application\Feature\DataMapper\V1\Service;

use InvalidArgumentException;
use Application\Feature\DomainModel\V1\Model\Entry;
use Application\Feature\DomainModel\V1\Model\Environment;
use Application\Feature\DomainModel\V1\Model\Task;

class ArrayDataMapper implements DataMapperInterface
{
    /**
     * @return string
     */
    public function identifier()
    {
        return 'array.php';
    }

    /**
     * @param Entry $entry
     * @return array
     */
    public function mapFromEntryToData(Entry $entry)
    {
        $listOfAffectedEnvironment  = [];
        $taskTodo                   = $entry->taskToCommit();
        $taskUndo                   = $entry->taskToRevertOrNull();

        foreach ($entry->listOfAffectedEnvironment() as $environment) {
            $listOfAffectedEnvironment[] = [
                self::DATA_KEY_ENVIRONMENT_NAME         => $environment->name()
            ];
        }

        if ($entry->hasTaskToRevert()) {
             $array = [
                 self::DATA_KEY_UUID                            => $entry->uuid(),
                 self::DATA_KEY_CREATED_AT                      => $entry->createdAt(),
                 self::DATA_KEY_CREATED_BY                      => $entry->createdBy(),
                 self::DATA_KEY_LIST_OF_AFFECTED_ENVIRONMENT    => $listOfAffectedEnvironment,
                 self::DATA_KEY_NAME                            => $entry->name(),
                 self::DATA_KEY_TASK_TO_COMMIT                    => [
                     self::DATA_KEY_TASK_DESCRIPTION                 => $taskTodo->description(),
                     self::DATA_KEY_TASK_CLASS_NAME_OF_HANDLER       => $taskTodo->classNameOfTheHandler(),
                     self::DATA_KEY_TASK_RELATIVE_PATH_TO_THE_FILE   => $taskTodo->relativePathToTheFile()
                 ],
                 self::DATA_KEY_TASK_TO_REVERT                    => [
                     self::DATA_KEY_TASK_DESCRIPTION                 => $taskUndo->description(),
                     self::DATA_KEY_TASK_CLASS_NAME_OF_HANDLER       => $taskUndo->classNameOfTheHandler(),
                     self::DATA_KEY_TASK_RELATIVE_PATH_TO_THE_FILE   => $taskUndo->relativePathToTheFile()
                 ],
                 self::DATA_KEY_VERSION                      => self::CURRENT_VERSION
            ];
        } else {
            $array = [
                self::DATA_KEY_UUID                         => $entry->uuid(),
                self::DATA_KEY_CREATED_AT                   => $entry->createdAt(),
                self::DATA_KEY_CREATED_BY                   => $entry->createdBy(),
                self::DATA_KEY_LIST_OF_AFFECTED_ENVIRONMENT => $listOfAffectedEnvironment,
                self::DATA_KEY_NAME                         => $entry->name(),
                self::DATA_KEY_TASK_TO_COMMIT                    => [
                    self::DATA_KEY_TASK_DESCRIPTION                 => $taskTodo->description(),
                    self::DATA_KEY_TASK_CLASS_NAME_OF_HANDLER       => $taskTodo->classNameOfTheHandler(),
                    self::DATA_KEY_TASK_RELATIVE_PATH_TO_THE_FILE   => $taskTodo->relativePathToTheFile()
                ],
                null,
                self::DATA_KEY_VERSION                      => self::CURRENT_VERSION
            ];
        }

        return $array;
    }

    /**
     * @param mixed $data
     * @return Entry
     * @throws InvalidArgumentException
     */
    public function mapFromDataToEntry($data)
    {
        if (!is_array($data)) {
            //@todo - check for all mandatory properties?
            throw new InvalidArgumentException(
                'data must be an array'
            );
        }

        $listOfAffectedEnvironment  = [];

        foreach ($data[self::DATA_KEY_LIST_OF_AFFECTED_ENVIRONMENT] as $environment) {
            $listOfAffectedEnvironment[] = new Environment(
                $environment[self::DATA_KEY_ENVIRONMENT_NAME]
            );
        }

        return new Entry(
            $data[self::DATA_KEY_CREATED_AT],
            $data[self::DATA_KEY_CREATED_BY],
            $listOfAffectedEnvironment,
            $data[self::DATA_KEY_NAME],
            new Task(
                $data[self::DATA_KEY_TASK_TO_COMMIT][self::DATA_KEY_TASK_CLASS_NAME_OF_HANDLER],
                $data[self::DATA_KEY_TASK_TO_COMMIT][self::DATA_KEY_TASK_DESCRIPTION],
                $data[self::DATA_KEY_TASK_TO_COMMIT][self::DATA_KEY_TASK_RELATIVE_PATH_TO_THE_FILE]
            ),
            (
                isset($data[self::DATA_KEY_TASK_TO_REVERT])
                ? new Task(
                    $data[self::DATA_KEY_TASK_TO_REVERT][self::DATA_KEY_TASK_CLASS_NAME_OF_HANDLER],
                    $data[self::DATA_KEY_TASK_TO_REVERT][self::DATA_KEY_TASK_DESCRIPTION],
                    $data[self::DATA_KEY_TASK_TO_REVERT][self::DATA_KEY_TASK_RELATIVE_PATH_TO_THE_FILE]
                )
                : null
            ),
            $data[self::DATA_KEY_VERSION],
            $data[self::DATA_KEY_UUID]
        );
    }
}