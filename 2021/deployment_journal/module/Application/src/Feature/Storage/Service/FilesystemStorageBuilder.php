<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-09-15
 */

namespace Application\Feature\Storage\Service;

use Application\Service\BuilderInterface;
use FilesystemIterator;
use Application\Feature\DataMapper\V1\Service\JSONDataMapper;
use Application\Service\Generator\PathToTheJournalFileGenerator;
use Application\Feature\Storage\Service\FileSystemStorage\FileExtensionFilterIterator;
use RecursiveIteratorIterator;

class FilesystemStorageBuilder implements BuilderInterface
{
    const OPTION_MANDATORY_PATH_TO_THE_JOURNAL  = 'path_to_the_journal';

    /**
     * @param array $options
     *
     * @return mixed
     */
    public function build(
        array $options = []
    ) {
        $dataMapper         = new JSONDataMapper();
        $pathToTheJournal   = $options[self::OPTION_MANDATORY_PATH_TO_THE_JOURNAL];

        $pathToTheJournalFileGenerator  = new PathToTheJournalFileGenerator(
            $pathToTheJournal
        );

        $filesystemIterator = new FileExtensionFilterIterator(
            new RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(
                    $pathToTheJournal,
                    FilesystemIterator::CURRENT_AS_PATHNAME ^ FilesystemIterator::SKIP_DOTS
                ),
                RecursiveIteratorIterator::SELF_FIRST
            )
        );
        $filesystemIterator->injectExtensionToFilterFor($dataMapper->identifier());

        return new FileSystemStorage(
            $dataMapper,
            $filesystemIterator,
            $pathToTheJournalFileGenerator
        );
    }
}