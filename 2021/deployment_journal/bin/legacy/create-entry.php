<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-09-02
 */

require_once __DIR__ . '/../vendor/autoload.php';

$entryBuilder               = new \Net\Bazzline\DeploymentJournal\Service\Builder\EntryBuilder();
$fileSystemStorageBuilder   = new \Net\Bazzline\DeploymentJournal\Service\Builder\FileSystemStorageBuilder();

$entryBuilder->setPathToTheJournal(__DIR__ . '/../data/global');
$entry = $entryBuilder->build();

$fileSystemStorageBuilder->setPathToTheJournal(__DIR__ . '/../data/global');

$fileSystemStorage  = $fileSystemStorageBuilder->build();

$fileSystemStorage->create($entry);