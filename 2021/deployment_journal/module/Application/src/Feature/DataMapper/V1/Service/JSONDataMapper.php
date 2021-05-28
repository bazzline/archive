<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-08-31
 */

namespace Application\Feature\DataMapper\V1\Service;

use Application\Feature\DomainModel\V1\Model\Entry;

class JSONDataMapper extends ArrayDataMapper
{
    /**
     * @return string
     */
    public function identifier()
    {
        return 'json';
    }

    /**
     * @param Entry $entry
     * @return string
     */
    public function mapFromEntryToData(Entry $entry)
    {
        return json_encode(
            parent::mapFromEntryToData($entry),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * @param mixed $data
     * @return Entry
     */
    public function mapFromDataToEntry($data)
    {
        return parent::mapFromDataToEntry(
            json_decode(
                $data,
                JSON_OBJECT_AS_ARRAY
            )
        );
    }
}