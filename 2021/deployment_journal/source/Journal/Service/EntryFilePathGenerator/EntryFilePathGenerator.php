<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\Journal\Service\EntryFilePathGenerator;

use Net\Bazzline\DeploymentJournal\Journal\Model\Entry;

class EntryFilePathGenerator
{
    /** @var Entry */
    private $entry;

    public function setEntryUpfront(
        Entry $entry
    ) {
        $this->entry = $entry;
    }

    public function generate(): string
    {

    }
}