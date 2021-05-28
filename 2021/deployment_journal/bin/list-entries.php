<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-09-02
 */

require_once __DIR__ . '/../vendor/autoload.php';

$fileSystemStorageBuilder   = new \Net\Bazzline\DeploymentJournal\Service\Builder\FileSystemStorageBuilder();

$fileSystemStorageBuilder->setPathToTheJournal(__DIR__ . '/../data/global');

$fileSystemStorage  = $fileSystemStorageBuilder->build();

foreach($fileSystemStorage->read() as $entry) {
    echo 'uuid: ' . $entry->uuid() . PHP_EOL;
    echo 'created at: ' . $entry->createdAt() . PHP_EOL;
    echo PHP_EOL;
};
