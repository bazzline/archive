<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-09-15
 */

namespace Application\Service;

interface BuilderInterface
{
    /**
     * @param array $options
     *
     * @return mixed
     */
    public function build(
        array $options = []
    );
}