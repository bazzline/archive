<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-09-01
 */

namespace Application\Feature\Storage\Service;

use Iterator;
use Application\Feature\DomainModel\V1\Model\Entry;
use Application\Feature\DataMapper\V1\Service\DataMapperInterface;
use Application\Service\Generator\PathToTheJournalFileGenerator;
use RuntimeException;

class FileSystemStorage implements StorageInterface
{
    /** @var DataMapperInterface */
    private $dataMapper;

    /** @var PathToTheJournalFileGenerator */
    private $pathToTheJournalFileGenerator;

    /** @var Iterator */
    private $filesystemIterator;

    /** @var array */
    private $fileSystemIteratorCache;

    /**
     * @param DataMapperInterface $dataMapper
     * @param Iterator $filesystemIterator
     * @param PathToTheJournalFileGenerator $pathToTheJournalFileGenerator,
     */
    public function __construct(
        DataMapperInterface $dataMapper,
        Iterator $filesystemIterator,
        PathToTheJournalFileGenerator $pathToTheJournalFileGenerator
    ) {
        $this->dataMapper                       = $dataMapper;
        $this->pathToTheJournalFileGenerator    = $pathToTheJournalFileGenerator;
        $this->filesystemIterator               = $filesystemIterator;

        $this->resetFileSystemIteratorCache();
    }

    /**
     * @param Entry $entry
     * @throws RuntimeException
     */
    public function create(Entry $entry)
    {
        //begin of dependencies
        $dataMapper                     = $this->dataMapper;
        $pathToTheJournalFileGenerator  = $this->pathToTheJournalFileGenerator;
        //end of dependencies

        //begin of business logic
        $data       = $dataMapper->mapFromEntryToData($entry);
        $filePath   = $this->generateFilePath(
            $dataMapper,
            $entry,
            $pathToTheJournalFileGenerator
        );

        $integerOrFalse = file_put_contents(
            $filePath,
            $data
        );

        $this->resetFileSystemIteratorCache();

        if ($integerOrFalse === false) {
            throw new RuntimeException(
                sprintf(
                    'could not create file in path "%s" with data "%s"',
                    $filePath,
                    $data
                )
            );
        }
        //end of business logic
    }

    /**
     * @param Entry $entry
     * @throws RuntimeException
     */
    public function delete(Entry $entry)
    {
        //begin of dependencies
        $dataMapper                     = $this->dataMapper;
        $pathToTheJournalFileGenerator  = $this->pathToTheJournalFileGenerator;
        //end of dependencies

        //begin of business logic
        $filePath   = $this->generateFilePath(
            $dataMapper,
            $entry,
            $pathToTheJournalFileGenerator
        );

        $trueOrFalse = unlink($filePath);

        $this->resetFileSystemIteratorCache();

        if ($trueOrFalse === false) {
            throw new RuntimeException(
                sprintf(
                    'could not delete file in path "%s"',
                    $filePath
                )
            );
        }
        //end of business logic
    }

    /**
     * @param null|array|string[] $listOfUUID
     * @return array|Entry[]
     */
    public function read(array $listOfUUID = null)
    {
        //begin of dependencies
        $dataMapper         = $this->dataMapper;
        $fileSystemIterator = $this->filesystemIterator;
        $listOfEntry        = [];
        //end of dependencies

        //begin of business logic
        //  begin of fetching the content
        $cacheIsEmpty   = (empty($this->fileSystemIteratorCache));

        if ($cacheIsEmpty) {
            foreach ($fileSystemIterator as $pathname) {
                $this->fileSystemIteratorCache[] = $pathname;
            }
        }
        //  end of fetching the content

        //  begin of processing the content
        $filterEntry    = (!is_null($listOfUUID));

        if ($filterEntry) {
            $listOfUUIDAsIndex  = array_flip($listOfUUID);

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
                    $listOfEntry[] = $dataMapper->mapFromDataToEntry(
                        file_get_contents(
                            $pathname
                        )
                    );
                }
            }
        } else {
            foreach ($this->fileSystemIteratorCache as $pathname) {
                $listOfEntry[] = $dataMapper->mapFromDataToEntry(
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

    /**
     * @param string $uuid
     * @return null|Entry
     */
    public function readOne($uuid)
    {
        $listOfEntry    = $this->read([$uuid]);

        return $listOfEntry[0];
    }

    private function resetFileSystemIteratorCache()
    {
        $this->fileSystemIteratorCache    = [];
    }

    /**
     * @param DataMapperInterface $dataMapper,
     * @param Entry $entry
     * @param PathToTheJournalFileGenerator $pathToTheJournalFileGenerator
     * @return string
     */
    private function generateFilePath(
        DataMapperInterface $dataMapper,
        Entry $entry,
        PathToTheJournalFileGenerator $pathToTheJournalFileGenerator
    ) {
        $pathToTheJournalFileGenerator->setEntry($entry);
        $path = $pathToTheJournalFileGenerator->generate();

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        return $path
            . DIRECTORY_SEPARATOR
            . $entry->uuid()
            . '.'
            . $dataMapper->identifier();
    }
}
