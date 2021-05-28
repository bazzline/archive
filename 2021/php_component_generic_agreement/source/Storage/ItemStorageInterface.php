<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-07 
 */

namespace Net\Bazzline\Component\GenericAgreement\Storage;

use Net\Bazzline\Component\GenericAgreement\Exception\InvalidArgument;
use Net\Bazzline\Component\GenericAgreement\Exception\Runtime;

interface ItemStorageInterface
{
    /**
     * @param mixed $value
     * @param string $key
     * @return mixed
     * @throws InvalidArgument|Runtime
     */
    public function createItem($value, $key = null);

    /**
     * @param string $key
     * @return null
     * @throws InvalidArgument|Runtime
     */
    public function deleteItem($key);

    /**
     * @param string $key
     * @return null|mixed
     * @throws InvalidArgument|Runtime
     */
    public function readItem($key);

    /**
     * @param mixed $value
     * @param string $key
     * @return mixed
     * @throws InvalidArgument|Runtime
     */
    public function updateItem($value, $key);
}