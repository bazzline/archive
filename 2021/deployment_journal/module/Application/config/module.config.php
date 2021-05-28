<?php
/**
 * @author add_new_module.sh/0.0.1
 * @since 18-09-09
 */

use Application\Controller;
use Application\Feature\Console;
use Application\Feature\DomainModel;
use Application\Feature\Storage;
use Application\Service\Generator\CurrentDateTimeGenerator;

return [
    //begin of zend framework configuration section
    'controllers' => [
        'factories' => [
            //console
            Controller\Console\Entity\CreateController::class   => Controller\Console\Entity\CreateControllerFactory::class,
            Controller\Console\Entity\ListController::class     => Controller\Console\Entity\ListControllerFactory::class
            //http
        ]
    ],
    'service_manager' => [
        'invokables' => [
            CurrentDateTimeGenerator::class => CurrentDateTimeGenerator::class,

            Console\V1\Output\Service\DynamicColumnWidthTableBuilder::class    => Console\V1\Output\Service\DynamicColumnWidthTableBuilder::class,

            Storage\Service\FilesystemStorageBuilder::class => Storage\Service\FilesystemStorageBuilder::class
        ],
        'factories' => [
            Console\V1\Input\Service\FetchInput::class  => Console\V1\Input\Service\FetchInputFactory::class,

            DomainModel\V1\Model\EntityConfiguration::class => DomainModel\V1\Model\EntityConfigurationFactory::class,

            Storage\Service\GlobalStorageFactory::VIRTUAL_INSTANCE_NAME => Storage\Service\GlobalStorageFactory::class,
            Storage\Service\LocalStorageFactory::VIRTUAL_INSTANCE_NAME  => Storage\Service\LocalStorageFactory::class
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
    ]
    //end of zend framework configuration section
];
