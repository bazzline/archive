<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\UnifiedJournal\Comparator\Service;

use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\EntityInterface;

interface ComparatorInterface
{
    /**
     * @param StorageInterface $storage
     */
    public function setGlobalStorageUpfront(StorageInterface $storage);

    /**
     * @param StorageInterface $storage
     */
    public function setLocalStorageUpfront(StorageInterface $storage);

    public function compare();

    /**
     * @return array|EntityInterface[];
     */
    public function getListOfEntitiesOnlyAvailableInGlobalStorageAfterwards(): array;

    /**
     * @return array|EntityInterface[]
     */
    public function getListOfEntitiesOnlyAvailableInLocalStorageAfterwards(): array;
}