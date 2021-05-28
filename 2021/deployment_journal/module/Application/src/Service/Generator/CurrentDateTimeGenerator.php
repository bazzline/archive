<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-09-15
 */

namespace Application\Service\Generator;

class CurrentDateTimeGenerator implements GeneratorInterface
{
    const FORMAT = 'Y-m-d H:i:s';

    /**
     * @return mixed
     */
    public function generate()
    {
        return date(
            self::FORMAT,
            time()
        );
    }
}