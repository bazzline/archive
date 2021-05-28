<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\UnifiedJournal\Journal\Model;

use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\EntityInterface;

interface EntryInterface extends EntityInterface
{
    /**
     * @param string $environment
     * @return bool
     */
    public function isAffectedBy(string $environment): bool;
}