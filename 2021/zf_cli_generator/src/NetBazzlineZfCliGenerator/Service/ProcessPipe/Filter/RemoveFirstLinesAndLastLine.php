<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-11 
 */

namespace NetBazzlineZfCliGenerator\Service\ProcessPipe\Filter;

use Net\Bazzline\Component\ProcessPipe\ExecutableException;
use Net\Bazzline\Component\ProcessPipe\ExecutableInterface;

class RemoveFirstLinesAndLastLine implements ExecutableInterface
{
    /**
     * @param mixed $input
     * @return mixed
     * @throws ExecutableException
     */
    public function execute($input = null)
    {
        if (!is_array($input)) {
            throw new ExecutableException(
                'input must be an array'
            );
        }

        if (empty($input)) {
            throw new ExecutableException(
                'empty input provided'
            );
        }

        if (count($input) < 4) {
            throw new ExecutableException(
                'input contains not enough rows'
            );
        }

        $isNotFirstModuleHeadline = true;

        while ($isNotFirstModuleHeadline) {
            $line                       = trim(array_shift($input));
            $isNotFirstModuleHeadline   = (
                (isset($line[0]))
                && ($line[0] !== '-')
            );
        }

        array_pop($input);

        return $input;
    }
}