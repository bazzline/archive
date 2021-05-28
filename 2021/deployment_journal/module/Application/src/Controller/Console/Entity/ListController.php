<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-09-15
 */

namespace Application\Controller\Console\Entity;

use Application\Controller\Console\AbstractConsoleController;
use Application\Feature\Console\V1\Output\Service\DynamicColumnWidthTableBuilder;
use Application\Feature\Storage\Service\StorageInterface;
use Zend\Console\Adapter\AdapterInterface;

class ListController extends AbstractConsoleController
{
    const ROUTE_NAME_WITHOUT_LIST_OF_ARGUMENT   = 'deployment-journal entity-list';
    const ROUTE_NAME_LIST_OF_ARGUMENT           = '[-a|--all] [-g|--global] [-l|--local]';

    /** @var AdapterInterface */
    private $console;

    /** @var StorageInterface */
    private $globalStorage;

    /** @var StorageInterface */
    private $localStorage;

    /** @var DynamicColumnWidthTableBuilder */
    private $dynamicColumnWidthTableBuilder;

    /**
     * ListController constructor.
     *
     * @param AdapterInterface $console
     * @param DynamicColumnWidthTableBuilder $dynamicColumnWidthTableBuilder
     * @param StorageInterface $globalStorage
     * @param StorageInterface $localStorage
     */
    public function __construct(
        AdapterInterface $console,
        DynamicColumnWidthTableBuilder $dynamicColumnWidthTableBuilder,
        StorageInterface $globalStorage,
        StorageInterface $localStorage
    ) {
        $this->console                          = $console;
        $this->globalStorage                    = $globalStorage;
        $this->localStorage                     = $localStorage;
        $this->dynamicColumnWidthTableBuilder   = $dynamicColumnWidthTableBuilder;
    }

    public function indexAction()
    {
        //begin of dependency
        $console        = $this->console;
        $globalStorage  = $this->globalStorage;
        $localStorage   = $this->localStorage;
        $tableBuilder   = $this->dynamicColumnWidthTableBuilder;

        $listAll    = $this->isBooleanParameterSet('a', 'all');
        $listGlobal = $this->isBooleanParameterSet('g', 'global');
        $listLocal  = $this->isBooleanParameterSet('l', 'local');
        //end of dependency

        //begin of business logic
        if (
            !$listAll
            && !$listGlobal
            && !$listLocal
        ) {
            $listAll = true;
        }

        if (
            $listAll
            || $listGlobal
        ) {
            $this->listStorage(
                $console,
                $tableBuilder,
                'global',
                $globalStorage
            );
        }

        if (
            $listAll
            || $listLocal
        ) {
            $this->listStorage(
                $console,
                $tableBuilder,
                'local',
                $localStorage
            );
        }
        //end of business logic
    }

    private function listStorage(
        AdapterInterface $console,
        DynamicColumnWidthTableBuilder $tableBuilder,
        string $name,
        StorageInterface $storage
    ) {
        $console->writeLine(
            sprintf(
                ':: Begin of listing >>%s<< journal.',
                $name
            )
        );

        $tableBuilder->setListOfHeadlineColumnRow(
            [
                'UUID',
                'Created At',
                'Name'
            ]
        );
        foreach ($storage->read() as $entry) {
            $tableBuilder->addTableColumnRow(
                [
                    $entry->uuid(),
                    $entry->createdAt(),
                    $entry->name()
                ]
            );
        }
        $console->write(
            $tableBuilder->build()->render()
        );

        $console->writeLine(
            sprintf(
                ':: End of listing >>%s<< journal.',
                $name
            )
        );
    }
}