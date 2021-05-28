<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\UnifiedJournal\Journal\Service;

use Net\Bazzline\DeploymentJournal\UnifiedJournal\Journal\Model\EntryInterface;

interface StorageInterface
{
    /**
     * @param string $uuid
     *
     * @return null|EntryInterface
     */
    public function readOne(string $uuid);

    /**
     * @param null|array $filterByListOfUUID
     *
     * @return array|EntryInterface[]
     */
    public function readMany(array $filterByListOfUUID = null): array;
}