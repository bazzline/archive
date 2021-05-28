<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-09-02
 */

namespace Application\Service\Generator;

interface GeneratorInterface
{
    /**
     * @return mixed
     */
    public function generate();
}