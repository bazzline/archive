<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-08-31
 */

namespace Application\Feature\DomainModel\V1\Model;

class Task
{
    /** @var string */
    private $classNameOfTheHandler;

    /** @var string */
    private $description;

    /** @var string */
    private $relativePathToTheFile;

    /**
     * Task constructor.
     *
     * @param string $classNameOfTheHandler
     * @param string $description
     * @param string $relativePathToTheFile
     */
    public function __construct(
        $classNameOfTheHandler,
        $description,
        $relativePathToTheFile
    ) {
        $this->classNameOfTheHandler    = $classNameOfTheHandler;
        $this->description              = $description;
        $this->relativePathToTheFile    = $relativePathToTheFile;
    }

    /**
     * @return string
     */
    public function classNameOfTheHandler()
    {
        return $this->classNameOfTheHandler;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function relativePathToTheFile()
    {
        return $this->relativePathToTheFile;
    }
}
