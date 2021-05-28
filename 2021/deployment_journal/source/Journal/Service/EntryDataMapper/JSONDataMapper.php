<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\Journal\Service\EntryDataMapper;

use Net\Bazzline\DeploymentJournal\Journal\Model\Entry;

class JSONDataMapper extends ArrayDataMapper
{
    /** @return string */
    public function identifier()
    {
        return 'json';
    }

    /**
     * @param Entry $entry
     *
     * @return string
     */
    public function mapFromEntryToData(
        Entry $entry
    ): string {
        return json_encode(
            parent::mapFromEntryToData($entry),
            JSON_PRETTY_PRINT
        );
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
        return parent::mapFromDataToEntry(
            json_decode(
                $data,
                JSON_OBJECT_AS_ARRAY
            )
        );
    }
}