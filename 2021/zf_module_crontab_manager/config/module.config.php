<?php

use Net\Bazzline\Zf\CrontabManaer\Controller\Console\AuditController;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\AuditControllerFactory;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\DisableController;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\DisableControllerFactory;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\EnableController;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\EnableControllerFactory;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\ListController;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\ListControllerFactory;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\UpdateController;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\UpdateControllerFactory;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Configuration;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\ConfigurationFactory;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\Dump\ArchiverDumpSectionConfiguration;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\Dump\ArchiverDumpSectionConfigurationFactory;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\DumpSectionConfiguration;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\DumpSectionConfigurationFactory;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\LockSectionConfiguration;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\LockSectionConfigurationFactory;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\TemplateSectionConfiguration;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\TemplateSectionConfigurationFactory;
use Net\Bazzline\Zf\CrontabManaer\Service\Command\CommandExecutor;
use Net\Bazzline\Zf\CrontabManaer\Service\Command\CommandExecutorFactory;
use Net\Bazzline\Zf\CrontabManaer\Service\Crontab\CrontabService;
use Net\Bazzline\Zf\CrontabManaer\Service\Crontab\CrontabServiceFactory;
use Net\Bazzline\Zf\CrontabManaer\Service\Crontab\SectionManager;
use Net\Bazzline\Zf\CrontabManaer\Service\Crontab\SectionManagerFactory;
use Net\Bazzline\Zf\CrontabManaer\Service\CrontabManagerFactory;
use Net\Bazzline\Zf\CrontabManaer\Service\LockFile\LockFile;
use Net\Bazzline\Zf\CrontabManaer\Service\LockFile\LockFileFactory;
use Net\Bazzline\Zf\CrontabManaer\Service\Storage\FileStorage;
use Net\Bazzline\Zf\CrontabManaer\Service\Storage\FileStorageFactory;
use Net\Bazzline\Zf\CrontabManaer\Service\Template\Renderer;

return [
    //begin of zend framework configuration section
    'controllers' => [
        'factories' => [
            //console
            AuditController::class      => AuditControllerFactory::class,
            DisableController::class    => DisableControllerFactory::class,
            EnableController::class     => EnableControllerFactory::class,
            ListController::class       => ListControllerFactory::class,
            UpdateController::class     => UpdateControllerFactory::class
        ]
    ],
    'service_manager' => [
        'invokables' => [
            Renderer::class => Renderer::class
        ],
        'factories' => [
            ArchiverDumpSectionConfiguration::class => ArchiverDumpSectionConfigurationFactory::class,
            CommandExecutor::class                  => CommandExecutorFactory::class,
            Configuration::class                    => ConfigurationFactory::class,
            CrontabManager::class                   => CrontabManagerFactory::class,
            CrontabService::class                   => CrontabServiceFactory::class,
            DumpSectionConfiguration::class         => DumpSectionConfigurationFactory::class,
            FileStorage::class                      => FileStorageFactory::class,
            LockSectionConfiguration::class         => LockSectionConfigurationFactory::class,
            LockFile::class                         => LockFileFactory::class,
            SectionManager::class                   => SectionManagerFactory::class,
            TemplateSectionConfiguration::class     => TemplateSectionConfigurationFactory::class
        ],
        'shared' => [
        ]
    ],
    'view_manager' => [
        'template_map' => [
        ],
        'template_path_stack' => [
            __DIR__ . '/../views',
            __DIR__ . '/../views/partials'
        ]
    ],
    'view_helpers' => [
        'invokables' => [
        ],
        'factories' => [
        ],
    ],
    //end of zend framework configuration section
];
