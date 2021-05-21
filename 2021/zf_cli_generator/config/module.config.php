<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-08
 */

return [
    'controllers' => [
        'factories' => [
            'NetBazzlineZfCliGenerator\Controller\Console\Index' => 'NetBazzlineZfCliGenerator\Controller\Console\IndexControllerFactory'
        ]
    ],
    'console' => [
        'router' => [
            'routes' => [
                'net_bazzline_cli_generate_configuration' => [
                    'options' => [
                        'route' => 'net_bazzline cli_generator configuration',
                        'defaults' => [
                            'controller' => 'NetBazzlineZfCliGenerator\Controller\Console\Index',
                            'action' => 'configuration'
                        ]
                    ]
                ],
                'net_bazzline_cli_generate_cli' => [
                    'options' => [
                        'route' => 'net_bazzline cli_generator cli',
                        'defaults' => [
                            'controller' => 'NetBazzlineZfCliGenerator\Controller\Console\Index',
                            'action' => 'cli'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'service_manager' => [
        'factories' => [
            'NetBazzlineCliGeneratorGenerateCliContent'            => 'NetBazzlineZfCliGenerator\Service\GenerateCliContentFactory',
            'NetBazzlineCliGeneratorGenerateConfigurationContent'  => 'NetBazzlineZfCliGenerator\Service\GenerateConfigurationContentFactory'
        ]
    ]
];
