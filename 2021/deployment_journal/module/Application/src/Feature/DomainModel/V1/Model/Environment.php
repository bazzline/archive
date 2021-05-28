<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-08-31
 */

namespace Application\Feature\DomainModel\V1\Model;

class Environment
{
    /** @var string */
    private $name;

    /**
     * Environment constructor.
     *
     * @param string $name
     * @param null|string $finishedAt
     */
    public function __construct(
        $name
    ) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}