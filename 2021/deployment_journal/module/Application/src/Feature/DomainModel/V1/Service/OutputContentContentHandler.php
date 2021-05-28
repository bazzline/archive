<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-08-31
 */

namespace Application\Feature\DomainModel\V1\Service;

use RuntimeException;

class OutputContentContentHandler implements TaskContentHandlerInterface
{
    /**
     * @param string $content
     * @throws RuntimeException
     */
    public function handle($content)
    {
        //begin of business logic
        foreach (explode(PHP_EOL, $content) as $line) {
            echo $line . PHP_EOL;
        }
        //end of business logic
    }
}