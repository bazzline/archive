<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-09-03
 */

require_once __DIR__ . '/../vendor/autoload.php';

$fileSystemStorageBuilder   = new \Net\Bazzline\DeploymentJournal\Service\Builder\FileSystemStorageBuilder();

$fileSystemStorageBuilder->setPathToTheJournal(__DIR__ . '/../data/local');
$localFileSystemStorage  = $fileSystemStorageBuilder->build();

$fileSystemStorageBuilder->setPathToTheJournal(__DIR__ . '/../data/global');
$globalFileSystemStorage  = $fileSystemStorageBuilder->build();

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
    if (isset($listOfLocalUUIDAsIndex[$uuid])) {
        $listOfUUIDAndStatus[$uuid] = 'is committed';
    } else {
        $listOfUUIDAndStatus[$uuid] = 'must be committed';
    }
}

foreach($listOfLocalUUIDAsIndex as $uuid => $true) {
    if (!isset($listOfGlobalUUIDAsIndex[$uuid])) {
        $listOfUUIDAndStatus[$uuid] = 'must be reverted';
    }
}

foreach ($listOfUUIDAndStatus as $uuid => $status) {
    echo 'entry with uuid of ' . $uuid . ' is in the status of ' . $status . '.' . PHP_EOL;
}
