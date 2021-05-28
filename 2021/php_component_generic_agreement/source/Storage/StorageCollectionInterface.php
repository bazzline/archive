<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-07 
 */

namespace Net\Bazzline\Component\GenericAgreement\Storage;

use Net\Bazzline\Component\GenericAgreement\Exception\InvalidArgument;
use Net\Bazzline\Component\GenericAgreement\Exception\Runtime;

interface StorageCollectionInterface
{
    /**
     * @param mixed $value
     * @param array $keys
     * @return mixed
     * @throws InvalidArgument|Runtime
     */
    public function createCollection($value, array $keys = null);

    /**
     * @param array $keys
     * @return null
     * @throws InvalidArgument|Runtime
     */
    public function deleteCollection(array $keys);

    /**
     * @param array $keys
     * @return null|mixed
     * @throws InvalidArgument|Runtime
     */
    public function readCollection(array $keys);

    /**
     * @param mixed $value
     * @param array $keys
     * @return mixed
     * @throws InvalidArgument|Runtime
     */
    public function updateCollection($value, array $keys);
}