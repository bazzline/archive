<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\Journal\Service\Storage;

use Iterator;
use Net\Bazzline\DeploymentJournal\Journal\Model\Entry;
use Net\Bazzline\DeploymentJournal\Journal\Service\EntryDataMapper\EntryDataMapperInterface;
use Net\Bazzline\DeploymentJournal\Journal\Service\EntryFilePathGenerator\EntryFilePathGenerator;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\Comparator\Service\StorageInterface as ComparatorStorageInterface;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\Journal\Model\EntryInterface;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\Journal\Service\StorageInterface as JournalStorageInterface;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\CalendarWeek;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\CalendarWeekInterface;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\EntityInterface;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\Year;
use Net\Bazzline\DeploymentJournal\UnifiedJournal\StorageComparator\Model\YearInterface;
use RuntimeException;

class FileSystemStorage implements ComparatorStorageInterface, JournalStorageInterface
{
    /** @var EntryDataMapperInterface */
    private $entryDataMapper;

    /** @var EntryFilePathGenerator */
    private $entryFilePathGenerator;

    /** @var Iterator */
    private $fileSystemIterator;

    /** @var array */
    private $fileSystemIteratorCache;

    /**
     * FileSystemStorage constructor.
     *
     * @param EntryDataMapperInterface $entryDataMapper
     * @param EntryFilePathGenerator $entryFilePathGenerator
     * @param Iterator $fileSystemIterator
     */
    public function __construct(
        EntryDataMapperInterface $entryDataMapper,
        EntryFilePathGenerator $entryFilePathGenerator,
        Iterator $fileSystemIterator
    ) {
        $this->entryDataMapper          = $entryDataMapper;
        $this->entryFilePathGenerator   = $entryFilePathGenerator;
        $this->fileSystemIterator       = $fileSystemIterator;

        $this->resetFileSystemIteratorCache();
    }



    //begin of ComparatorStorageInterface
    /**
     * @param EntityInterface|Entry $entry
     */
    public function createEntity(
        EntityInterface $entry
    ) {
        $this->throwInvalidArgumentExceptionIfEntryIsNotSupported($entry);

        //begin of dependencies
        $entryDataMapper        = $this->entryDataMapper;
        $entryFilePathGenerator = $this->entryFilePathGenerator;
        //end of dependencies

        //begin of business logic
        $data       = $entryDataMapper->mapFromEntryToData($entry);
        $filePath   = $this->generateFilePath(
            $entryDataMapper,
            $entry,
            $entryFilePathGenerator
        );

        $integerOrFalse = file_put_contents(
            $filePath,
            $data
        );

        $this->resetFileSystemIteratorCache();

        if ($integerOrFalse === false) {
            throw new RuntimeException(
                sprintf(
                    'Could not create file in path "%s" with data "%s".',
                    $filePath,
                    $data
                )
            );
        }
        //end of business logic
    }

    /**
     * @param EntityInterface|Entry $entry
     */
    public function deleteEntity(
        EntityInterface $entry
    ) {
        $this->throwInvalidArgumentExceptionIfEntryIsNotSupported($entry);

        //begin of dependencies
        $entryDataMapper        = $this->entryDataMapper;
        $entryFilePathGenerator = $this->entryFilePathGenerator;
        //end of dependencies

        //begin of business logic
        $filePath   = $this->generateFilePath(
            $entryDataMapper,
            $entry,
            $entryFilePathGenerator
        );

        $trueOrFalse = unlink($filePath);

        $this->resetFileSystemIteratorCache();

        if ($trueOrFalse === false) {
            throw new RuntimeException(
                sprintf(
                    'Could not delete file in path "%s".',
                    $filePath
                )
            );
        }
        //end of business logic
    }

    /**
     * @param YearInterface $year
     *
     * @return array|CalendarWeekInterface[]
     */
    public function readListOfCalendarWeeks(
        YearInterface $year
    ): array {
        //begin of dependencies
        $fileSystemIterator = $this->fileSystemIterator;
        $listOfCalendarWeek = [];
        //end of dependencies

        //begin of business logic
        $this->fillUpCacheIfNeeded(
            $fileSystemIterator
        );

        foreach ($this->fileSystemIteratorCache as $pathname) {
            $yearFromPathName = substr(
                $pathname,
                -49,    //49 = strlen('/32/2a7f46c9-32ac-42b6-96e2-8fe2df51bdd8.json')
                4
            );

            $hasFittingYear = ($yearFromPathName == $year->toString());

            if ($hasFittingYear) {
                $calendarWeek = substr(
                    $pathname,
                    -44,    //49 = strlen('/32/2a7f46c9-32ac-42b6-96e2-8fe2df51bdd8.json')
                    2
                );

                $addCalendarWeekToTheList = (!isset($listOfCalendarWeek[$calendarWeek]));

                if ($addCalendarWeekToTheList) {
                    $listOfCalendarWeek[$calendarWeek] = new CalendarWeek(
                        $calendarWeek,
                        $year
                    );
                }
            }
        }

        return $listOfCalendarWeek;
        //end of business logic
    }

    /**
     * @param CalendarWeekInterface $calendarWeek
     * @param YearInterface $year
     *
     * @return array|EntityInterface[]|Entry[] - [<uuid> => EntryInterface|Entry]
     */
    public function readListOfEntities(
        CalendarWeekInterface $calendarWeek,
        YearInterface $year
    ): array {
        // TODO: Implement readListOfCalendarWeeks() method.
        return [

        ];
    }

    /**
     * @return array|YearInterface[]
     */
    public function readListOfYears(): array
    {
        //begin of dependencies
        $fileSystemIterator = $this->fileSystemIterator;
        $listOfYear         = [];
        //end of dependencies

        //begin of business logic
        $this->fillUpCacheIfNeeded(
            $fileSystemIterator
        );

        foreach ($this->fileSystemIteratorCache as $pathname) {
            $year = substr(
                $pathname,
                -49,    //49 = strlen('/32/2a7f46c9-32ac-42b6-96e2-8fe2df51bdd8.json')
                4
            );

            $addYearToTheList = (!isset($listOfYear[$year]));

            if ($addYearToTheList) {
                $listOfYear[$year] = new Year(
                    $year
                );
            }
        }

        return $listOfYear;
        //end of business logic
    }
    //end of ComparatorStorageInterface

    //begin of JournalStorageInterface
    /**
     * @param string $uuid
     *
     * @return null|EntryInterface|Entry
     */
    public function readOne(
        string $uuid
    ) {
        $listOfEntry    = $this->readMany(
            [
                $uuid
            ]
        );

        return $listOfEntry[0];
    }

    /**
     * @param null|array $filterByListOfUUID
     *
     * @return array|EntryInterface[]|Entry[]
     */
    public function readMany(
        array $filterByListOfUUID = null
    ):array {
        //begin of dependencies
        $entryDataMapper    = $this->entryDataMapper;
        $fileSystemIterator = $this->fileSystemIterator;
        $listOfEntry        = [];
        //end of dependencies

        //begin of business logic
        $this->fillUpCacheIfNeeded(
            $fileSystemIterator
        );

        //  begin of processing the content
        $filterEntries = (!is_null($filterByListOfUUID));

        if ($filterEntries) {
            $listOfUUIDAsIndex  = array_flip($filterByListOfUUID);

            foreach ($this->fileSystemIteratorCache as $pathname) {
                $addItToTheList = (
                    isset(
                        $listOfUUIDAsIndex[
                            pathinfo(
                                $pathname,
                                PATHINFO_FILENAME
                            )
                        ]
                    )
                );

                if ($addItToTheList) {
                    $listOfEntry[] = $entryDataMapper->mapFromDataToEntry(
                        file_get_contents(
                            $pathname
                        )
                    );
                }
            }
        } else {
            foreach ($this->fileSystemIteratorCache as $pathname) {
                $listOfEntry[] = $entryDataMapper->mapFromDataToEntry(
                    file_get_contents(
                        $pathname
                    )
                );
            }
        }

        return $listOfEntry;
        //  end of processing the content
        //end of business logic
    }
    //end of JournalStorageInterface

    /**
     * @param Iterator $fileSystemIterator
     */
    private function fillUpCacheIfNeeded(
        Iterator $fileSystemIterator
    ) {
        //begin of business logic
        $cacheIsEmpty   = (empty($this->fileSystemIteratorCache));

        if ($cacheIsEmpty) {
            foreach ($fileSystemIterator as $pathname) {
                $this->fileSystemIteratorCache[] = $pathname;
            }
        }
        //end of business logic
    }

    /**
     * @param EntryDataMapperInterface $entryDataMapper ,
     * @param Entry $entry
     * @param EntryFilePathGenerator $entryFilePathGenerator
     *
     * @return string
     */
    private function generateFilePath(
        EntryDataMapperInterface $entryDataMapper,
        Entry $entry,
        EntryFilePathGenerator $entryFilePathGenerator
    ):string {
        $entryFilePathGenerator->setEntryUpfront($entry);
        $path = $entryFilePathGenerator->generate();

        if (!is_dir($path)) {
            mkdir(
                $path,
                0755,
                true
            );
        }

        return $path
            . DIRECTORY_SEPARATOR
            . $entry->uuid()
            . '.' . $entryDataMapper->identifier();
    }

    private function resetFileSystemIteratorCache()
    {
        $this->fileSystemIteratorCache    = [];
    }

    /**
     * @param EntityInterface $entry
     */
    private function throwInvalidArgumentExceptionIfEntryIsNotSupported(
        EntityInterface $entry
    ) {
        if (!($entry instanceof Entry)) {
            throw new RuntimeException(
                sprintf(
                    'Only entries of class >>%s<< supported.',
                    Entry::class
                )
            );
        }
    }
}
