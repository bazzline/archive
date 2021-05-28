<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-12-15
 */

namespace Application\Feature\DomainModel\V1\Model;

class EntityConfiguration
{
    /** @var array */
    private $listOfAffectedEnvironments;

    public function __construct(
        array $listOfAffectedEnvironments
    ) {
        $this->listOfAffectedEnvironments = $listOfAffectedEnvironments;
    }

    public function getListOfAffectedEnvironments(): array
    {
        return $this->listOfAffectedEnvironments;
    }
}