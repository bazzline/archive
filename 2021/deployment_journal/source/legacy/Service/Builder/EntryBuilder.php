<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-09-02
 */

namespace Net\Bazzline\DeploymentJournal\Service\Builder;

use Application\Feature\DomainModel\V1\Model\Entry;
use Application\Feature\DomainModel\V1\Model\Environment;
use Application\Feature\DomainModel\V1\Model\Task;
use Application\Feature\DataMapper\V1\Service\JSONDataMapper;
use Application\Feature\DomainModel\V1\Service\OutputContentContentHandler;
use Ramsey\Uuid\Uuid;

class EntryBuilder implements BuilderInterface
{
    /** @var string */
    private $pathToTheJournal;

    /**
     * @return mixed
     */
    public function build()
    {
        //begin of dependencies
        $uuid               = Uuid::uuid4()->toString();
        //end of dependencies

        //begin of business logic
        $createdAt                  = date('Y-m-d H:i:s', time());
        $createdBy                  = 'stev leibelt <artodeto@bazzline.net>';
        $listOfAffectedEnvironment  = [
            new Environment(
                'production'
            ),
            new Environment(
                'stage'
            )
        ];
        $taskToCommit               = new Task(
            OutputContentContentHandler::class,
            'this is a demo entry',
            $uuid . '/foo_to_commit.sh'
        );
        $taskToRevert               = null;
        $version                    = JSONDataMapper::CURRENT_VERSION;

        return new Entry(
            $createdAt,
            $createdBy,
            $listOfAffectedEnvironment,
            $taskToCommit,
            $taskToRevert,
            $version,
            $uuid
        );
        //end of business logic
    }

    /**
     * @param string $pathToTheJournal
     */
    public function setPathToTheJournal($pathToTheJournal)
    {
        $this->pathToTheJournal = $pathToTheJournal;
    }
}