<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-08-31
 */

namespace Application\Feature\DomainModel\V1\Service;

use RuntimeException;

interface TaskContentHandlerInterface
{
    /**
     * @param string $content
     * @throws RuntimeException
     */
    public function handle($content);
}