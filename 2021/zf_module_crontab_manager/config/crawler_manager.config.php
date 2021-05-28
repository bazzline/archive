<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

return [
    'crontab_manager'   => [
        'dump'  => [
            'archiver'  => [
                'archive_full_dump'             => true,
                'number_of_full_dumps_to_keep'  => 3
            ],
            'file_name_full_dump'       => 'full-crontab.dump',
            'file_name_section_dump'    => 'section-crontab.dump',
            'file_name_updated_dump'    => 'updated-crontab.dump',
            'root_path'                 => __DIR__ . '/../../../../data/crontab_manager/dump'   //data should be in the same level like the vendor directory
        ],
        'lock'  => [
            'file_path' => __DIR__ . '/../../../../data/crontab_manager/crontab_manager.lock'   //data should be in the same level like the vendor directory
        ],
        'logger'    => \Psr\Log\LoggerInterface::class,
        'template'  => [
            'file_name_rendered_template'   => 'section.rendered',
            'file_name_template'            => 'template.tpl',
            'list_of_template_key_to_value' => [
                //each key can be used in the template file as placeholder for the variable
                '{PATH_TO_THE_CRONTAB_LOG_FILE}'    => '/var/www/bazzline.net/my_example_bazzline_net_application/data/log/cronjob.log',
                '{PATH_TO_THE_INDEX_PHP}'           => '/var/www/bazzline.net/my_example_bazzline_net_application/public/index.php',
                '{PATH_TO_THE_PHP_BINARY}'          => '/usr/bin/php',
            ],
            'root_path'                     => __DIR__ . '/../../../../data/crontab_manager/template',  //data should be in the same level like the vendor directory
            'section_unique_identifier'     => 'crontab_manager_unique_section_identifier'
        ]
    ]
];