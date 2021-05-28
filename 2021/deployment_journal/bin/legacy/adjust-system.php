<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-09-13
 */

require_once __DIR__ . '/../vendor/autoload.php';

$fileSystemStorageBuilder   = new \Net\Bazzline\DeploymentJournal\Service\Builder\FileSystemStorageBuilder();

$fileSystemStorageBuilder->setPathToTheJournal(__DIR__ . '/../data/local');
$localFileSystemStorage  = $fileSystemStorageBuilder->build();

$fileSystemStorageBuilder->setPathToTheJournal(__DIR__ . '/../data/global');
$globalFileSystemStorage  = $fileSystemStorageBuilder->build();

$listOfUUIDWithStatusCommit = [];
$listOfUUIDWithStatusRevert = [];
$listOfLocalUUIDAsIndex     = [];
$listOfGlobalUUIDAsIndex    = [];
$listOfUUIDAndStatus        = [];

foreach($localFileSystemStorage->read() as $entry) {
    $listOfLocalUUIDAsIndex[$entry->uuid()] = true;
};

foreach($globalFileSystemStorage->read() as $entry) {
    $listOfGlobalUUIDAsIndex[$entry->uuid()] = true;
};

foreach($listOfGlobalUUIDAsIndex as $uuid => $true) {
    if (!isset($listOfLocalUUIDAsIndex[$uuid])) {
        $listOfUUIDWithStatusCommit[$uuid]  = true;
    }
}

foreach($listOfLocalUUIDAsIndex as $uuid => $true) {
    if (!isset($listOfGlobalUUIDAsIndex[$uuid])) {
        $listOfUUIDWithStatusRevert[$uuid]  = true;
    }
}

foreach ($listOfUUIDWithStatusCommit as $uuid => $true) {
    echo '@todo: committing entry with uuid ' . $uuid . PHP_EOL;
    $entry  = $globalFileSystemStorage->readOne($uuid);
    echo $entry->taskToCommit()->description() . PHP_EOL;
}

foreach ($listOfUUIDWithStatusRevert as $uuid => $true) {
    echo '@todo: reverting entry with uuid ' . $uuid . PHP_EOL;
    $entry = $localFileSystemStorage->readOne($uuid);

    if ($entry->hasTaskToRevert()) {
        echo $entry->taskToRevertOrNull()->description() . PHP_EOL;
    } else {
        echo '    Can not reverted.' . PHP_EOL;
    }
}
