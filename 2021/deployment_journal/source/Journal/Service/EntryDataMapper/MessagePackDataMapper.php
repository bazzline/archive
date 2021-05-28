<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-09-22
 */

namespace Net\Bazzline\DeploymentJournal\Journal\Service\EntryDataMapper;

use Application\Feature\DataMapper\V1\Service\ArrayDataMapper;
use Application\Feature\DomainModel\V1\Model\Entry;
use MessagePack\MessagePack;

class MessagePackDataMapper extends ArrayDataMapper
{
    /** @return string */
    public function identifier()
    {
        return 'msgpack';
    }

    /**
     * @param Entry $entry
     *
     * @return string
     */
    public function mapFromEntryToData(
        Entry $entry
    ): string {
        return MessagePack::pack(
            parent::mapFromEntryToData($entry)
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
            MessagePack::unpack(
                $data
            )
        );
    }
}