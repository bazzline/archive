<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-09-02
 */

namespace Application\Service\Generator;

use Application\Feature\DomainModel\V1\Model\Entry;
use Application\Feature\DomainModel\V1\Model\Task;

class PathToTheJournalFileGenerator implements GeneratorInterface
{
    /** @var string */
    private $pathToTheJournal;

    /** @var Entry */
    private $entry;

    /**
     * PathToTheJournalFileGenerator constructor.
     *
     * @param string $pathToTheJournal
     */
    public function __construct(
        $pathToTheJournal
    ) {
        $this->pathToTheJournal = $pathToTheJournal;
    }

    /**
     * @param Entry $entry
     */
    public function setEntry(Entry $entry)
    {
        $this->entry = $entry;
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        //begin of dependencies
        $entry              = $this->entry;
        $pathToTheJournal   = $this->pathToTheJournal;
        //end of dependencies

        //begin of business logic
        $listOfDateAndTime  = explode(' ', $entry->createdAt());
        $listOfDate         = explode('-', $listOfDateAndTime[0]);

        //or YYYY/CW?
        //date('W', time())
        return $pathToTheJournal
            . DIRECTORY_SEPARATOR
            . $listOfDate[0]    //year
            . DIRECTORY_SEPARATOR
            . date(
                'W',
                strtotime(
                    $entry->createdAt()
                )
            )
        ;
        /**
        return $pathToTheJournal
            . DIRECTORY_SEPARATOR
            . $listOfDate[0]    //year
            . DIRECTORY_SEPARATOR
            . $listOfDate[1]    //month
            . DIRECTORY_SEPARATOR
            . $listOfDate[2]    //day
            ;
        */
        //end of business logic
    }
}