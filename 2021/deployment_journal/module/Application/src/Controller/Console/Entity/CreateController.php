<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-09-15
 */

namespace Application\Controller\Console\Entity;

use Application\Controller\Console\AbstractConsoleController;
use Application\Feature\Console\V1\Input\Service\FetchInput;
use Application\Feature\DataMapper\V1\Service\JSONDataMapper;
use Application\Feature\DomainModel\V1\Model\EntityConfiguration;
use Application\Feature\DomainModel\V1\Model\Entry;
use Application\Feature\DomainModel\V1\Model\Environment;
use Application\Feature\DomainModel\V1\Model\Task;
use Application\Feature\DomainModel\V1\Service\CommandLineContentHandler;
use Application\Feature\DomainModel\V1\Service\OutputContentContentHandler;
use Application\Feature\Storage\Service\StorageInterface;
use Application\Service\Generator\CurrentDateTimeGenerator;
use Ramsey\Uuid\Uuid;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\Request;

class CreateController extends AbstractConsoleController
{
    const ROUTE_NAME_WITHOUT_LIST_OF_ARGUMENT   = 'deployment-journal entity-create';
    const ROUTE_NAME_LIST_OF_ARGUMENT           = '[--created_by=] [--list_of_affected_environment_names=] [--name=] [--task-to-commit-handler=] [--task-to-commit-description=] [--task-to-commit-relative-path-to-the-file=] [--task-to-revert-exists] [--task-to-revert-handler=] [--task-to-revert-description=] [--task-to-revert-relative-path-to-the-file=] [-v|--verbose]';

    /** @var AdapterInterface */
    private $console;

    /** @var CurrentDateTimeGenerator */
    private $currentDateTimeGenerator;

    /** @var EntityConfiguration */
    private $entityConfiguration;

    /** @var FetchInput */
    private $fetchInput;

    /** @var StorageInterface */
    private $storage;

    /**
     * CreateController constructor.
     *
     * @param AdapterInterface $console
     * @param CurrentDateTimeGenerator $currentDateTimeGenerator
     * @param EntityConfiguration $entityConfiguration
     * @param FetchInput $fetchInput
     * @param StorageInterface $storage
     */
    public function __construct(
        AdapterInterface $console,
        CurrentDateTimeGenerator $currentDateTimeGenerator,
        EntityConfiguration $entityConfiguration,
        FetchInput $fetchInput,
        StorageInterface $storage
    ) {
        $this->console                          = $console;
        $this->currentDateTimeGenerator         = $currentDateTimeGenerator;
        $this->entityConfiguration              = $entityConfiguration;
        $this->fetchInput                       = $fetchInput;
        $this->storage                          = $storage;
    }

    public function indexAction()
    {
        //begin of dependency
        $beVerbose                  = $this->beVerbose();
        $console                    = $this->console;
        $currentDateTimeGenerator   = $this->currentDateTimeGenerator;
        $entityConfiguration        = $this->entityConfiguration;
        $fetchInput                 = $this->fetchInput;
        $request                    = $this->getRequest();
        $storage                    = $this->storage;
        //end of dependency

        //begin of business logic
        $createdAt = $currentDateTimeGenerator->generate();
        $createdBy = $fetchInput->askForSingleLine(
            $beVerbose,
            'created_by',
            $request
        );
        $stringOfAffectedEnvironmentNames  = $fetchInput->letSelectFromListOfOption(
            $beVerbose,
            'list_of_affected_environment_names',
            $entityConfiguration->getListOfAffectedEnvironments(),
            $request,
            null,
            true
        );
        $name   = $fetchInput->askForSingleLine(
            $beVerbose,
            'name',
            $request
        );
        $version    = JSONDataMapper::CURRENT_VERSION;  //@todo inject as dependency
        $uuid       = Uuid::uuid4()->toString();    //@todo inject as dependency

        $arrayOfAffectedEnvironmentName = explode(
            ',',
            $stringOfAffectedEnvironmentNames
        );

        $listOfAffectedEnvironment = [];

        foreach ($arrayOfAffectedEnvironmentName as $environmentName) {
            $listOfAffectedEnvironment[] = new Environment(
                $environmentName
            );
        }

        $taskToCommit   = new Task(
            $fetchInput->letSelectFromListOfOption(
                $beVerbose,
                'task-to-commit-handler',
                [
                    OutputContentContentHandler::class,
                    CommandLineContentHandler::class
                ],
                $request,
                OutputContentContentHandler::class
            ),
            $fetchInput->askForSingleLine(
                $beVerbose,
                'task-to-commit-description',
                $request
            ),
            $uuid . '/' . $fetchInput->askForSingleLine(
                $beVerbose,
                'task-to-commit-relative-path-to-the-file',
                $request
            )
        );

        if (
            $fetchInput->letSelectFromListOfOption(
                $beVerbose,
                'tasl-to-revert-exists',
                [
                    'true',
                    'false'
                ],
                $request,
                'false'
            ) === 'true'
        ) {
            $taskToRevert   = new Task(
                $fetchInput->letSelectFromListOfOption(
                    $beVerbose,
                    'task-to-revert-handler',
                    [
                        OutputContentContentHandler::class,
                        CommandLineContentHandler::class
                    ],
                    $request,
                    OutputContentContentHandler::class
                ),
                $fetchInput->askForSingleLine(
                    $beVerbose,
                    'task-to-revert-description',
                    $request
                ),
                $uuid . '/' . $fetchInput->askForSingleLine(
                    $beVerbose,
                    'task-to-revert-relative-path-to-the-file',
                    $request
                )
            );
        } else {
            $taskToRevert = null;
        }

        $entry = new Entry(
            $createdAt,
            $createdBy,
            $listOfAffectedEnvironment,
            $name,
            $taskToCommit,
            $taskToRevert,
            $version,
            $uuid
        );

        $this->writeLineOnlyIfVerbosityIsEnabled(
            sprintf(
                'Storing entity >>%s<<.',
                json_encode(
                    var_export(
                        $entry,
                        true
                    )
                )
            ),
            $console,
            $beVerbose
        );

        $storage->create(
            $entry
        );
        //end of business logic
    }
}