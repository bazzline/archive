<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\UnifiedJournal\Comparator\Service;

use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\EntityInterface;

class Comparator implements ComparatorInterface
{
    /** @var StorageInterface */
    private $globalStorage;

    /** @var EntityInterface[] */
    private $listOfEntitiesInGlobalStorageOnly;

    /** @var EntityInterface[] */
    private $listOfEntitiesInLocalStorageOnly;

    /** @var StorageInterface */
    private $localStorage;

    /**
     * @param StorageInterface $storage
     */
    public function setGlobalStorageUpfront(StorageInterface $storage)
    {
        $this->globalStorage = $storage;
    }

    /**
     * @param StorageInterface $storage
     */
    public function setLocalStorageUpfront(StorageInterface $storage)
    {
        $this->localStorage = $storage;
    }

    public function compare()
    {
        //begin of dependencies
        $globalStorage  = $this->globalStorage;
        $localStorage   = $this->localStorage;
        //end of dependencies

        //begin of business logic
        $listOfEntitiesInGlobalStorage   = $this->createListOfEntitiesInStorage($globalStorage);
        $listOfEntitiesInLocalStorage    = $this->createListOfEntitiesInStorage($localStorage);

        $this->listOfEntitiesInGlobalStorageOnly = $this->createListOfEntitiesOnlyAvailableInTheFirstList(
            $listOfEntitiesInGlobalStorage,
            $listOfEntitiesInLocalStorage
        );
        $this->listOfEntitiesInLocalStorageOnly  = $this->createListOfEntitiesOnlyAvailableInTheFirstList(
            $listOfEntitiesInLocalStorage,
            $listOfEntitiesInGlobalStorage
        );
        //end of business logic
    }

    /**
     * @return array|EntityInterface[];
     */
    public function getListOfEntitiesOnlyAvailableInGlobalStorageAfterwards(): array
    {
        return $this->listOfEntitiesInGlobalStorageOnly;
    }

    /**
     * @return array|EntityInterface[]
     */
    public function getListOfEntitiesOnlyAvailableInLocalStorageAfterwards(): array
    {
        return $this->listOfEntitiesInLocalStorageOnly;
    }

    /**
     * @param array $firstListOfEntities
     * @param array $secondListOfEntities
     *
     * @return array
     */
    private function createListOfEntitiesOnlyAvailableInTheFirstList(
        array $firstListOfEntities,
        array $secondListOfEntities
    ) {
        //begin of business logic
        return array_diff($firstListOfEntities, $secondListOfEntities);
        //end of business logic
    }

    /**
     * @param StorageInterface $storage
     *
     * @return EntityInterface[]
     */
    private function createListOfEntitiesInStorage(StorageInterface $storage)
    {
        //begin of dependencies
        $listOfEntities = [];
        //end of dependencies

        //begin of business logic
        $listOfYears = $storage->readListOfYears();

        foreach ($listOfYears as $year) {
            $listOfCalendarWeek = $storage->readListOfCalendarWeeks($year);

            foreach ($listOfCalendarWeek as $calendarWeek) {
                array_merge(
                    $listOfEntities,
                    $storage->readListOfEntities(
                        $calendarWeek,
                        $year
                    )
                );
            }
        }

        return $listOfEntities;
        //end of business logic
    }
}