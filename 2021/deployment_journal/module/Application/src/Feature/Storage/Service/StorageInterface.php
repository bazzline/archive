<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-08-31
 */

namespace Application\Feature\Storage\Service;

use Application\Feature\DomainModel\V1\Model\Entry;
use RuntimeException;

interface StorageInterface
{
    /**
     * @param Entry $entry
     * @throws RuntimeException
     */
    public function create(Entry $entry);

    /**
     * @param Entry $entry
     * @throws RuntimeException
     */
    public function delete(Entry $entry);

    /**
     * @param null|array|string[] $listOfUUID
     * @return array|Entry[]
     */
    public function read(array $listOfUUID = null);

    /**
     * @param string $uuid
     * @return null|Entry
     */
    public function readOne($uuid);
}