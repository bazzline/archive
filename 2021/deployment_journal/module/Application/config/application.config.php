<?php
/**
 * @author add_new_module.sh/0.0.1
 * @since 18-09-09
 */

use Application\Feature\Storage\Service\FileSystemStorage;
use Application\Feature\Storage\Service\FilesystemStorageBuilder;
use Application\Feature\Storage\Service\StorageInterface;

return [
    //begin of module configuration section
    'application' => [
        'entity'    => [
            'list_of_affected_environments' => [
                //array values are the names for that environment
            ]
        ],
        'storage'   => [
            'global' => [
                StorageInterface::class => FileSystemStorage::class,
                'options'   => [
                    FilesystemStorageBuilder::OPTION_MANDATORY_PATH_TO_THE_JOURNAL  => __DIR__ . '/../../../data/journal/global'
                ]
            ],
            'local' => [
                StorageInterface::class => FileSystemStorage::class,
                'options'   => [
                    FilesystemStorageBuilder::OPTION_MANDATORY_PATH_TO_THE_JOURNAL  => __DIR__ . '/../../../data/journal/local'
                ]
            ]
        ]
    ]
    //end of module configuration section
];
