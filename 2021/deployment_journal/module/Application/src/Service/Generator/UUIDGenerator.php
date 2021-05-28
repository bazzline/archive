<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-09-02
 */

namespace Application\Service\Generator;

use Ramsey\Uuid\Uuid;

class UUIDGenerator implements GeneratorInterface
{
    /**
     * @return mixed
     */
    public function generate()
    {
        return Uuid::uuid4();
    }
}