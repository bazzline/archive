<?php

use Net\Bazzline\Zf\CrontabManaer\Controller\Console\AuditController;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\DisableController;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\EnableController;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\ListController;
use Net\Bazzline\Zf\CrontabManaer\Controller\Console\UpdateController;

return [
    //http routes
    'router' => [
        'routes' => [
                //'application_http_route_name'   => [
                //  'options'   => [
                //      'defaults'  => [
                //          'action'        => 'methodNameWithoutSuffixAction',
                //          'controller'    => MyFancyController::class,
                //          'module'        => 'Application'
                //      ],
                //      'route' => '{/foo-bar}/:id'
                //  ],
                //  'type'  => \Zend\Router\Http\Segment::class
                //]
        ],
    ],
    //console routes
    'console' => [
        'router' => [
            'routes' => [
                //'application_console_route_name'   => [
                //  'options'   => [
                //      'defaults'  => [
                //          'action'        => 'methodNameWithoutSuffixAction',
                //          'controller'    => MyFancyController::class
                //      ],
                //      'route' => 'application my-console-command [--verbose|-v]
                //  ]
                //]
                'crontab_manager_audit' => [
                    'options'   => [
                        'defaults'  => [
                            'action'        => 'index',
                            'controller'    => AuditController::class
                        ],
                        'route' => 'crawler-manager audit [-v]'
                    ]
                ],
                'crontab_manager_disable_full' => [
                    'options'   => [
                        'defaults'  => [
                            'action'        => 'full',
                            'controller'    => DisableController::class
                        ],
                        'route' => 'crawler-manager disable full [-v]'
                    ]
                ],
                'crontab_manager_disable_section' => [
                    'options'   => [
                        'defaults'  => [
                            'action'        => 'section',
                            'controller'    => DisableController::class
                        ],
                        'route' => 'crawler-manager disable section [-v]'
                    ]
                ],
                'crontab_manager_enable_full' => [
                    'options'   => [
                        'defaults'  => [
                            'action'        => 'full',
                            'controller'    => EnableController::class
                        ],
                        'route' => 'crawler-manager enable full [-v]'
                    ]
                ],
                'crontab_manager_enable_section' => [
                    'options'   => [
                        'defaults'  => [
                            'action'        => 'section',
                            'controller'    => EnableController::class
                        ],
                        'route' => 'crawler-manager enable section [-v]'
                    ]
                ],
                'crontab_manager_list_full' => [
                    'options'   => [
                        'defaults'  => [
                            'action'        => 'full',
                            'controller'    => ListController::class
                        ],
                        'route' => 'crawler-manager list full'
                    ]
                ],
                'crontab_manager_list_section' => [
                    'options'   => [
                        'defaults'  => [
                            'action'        => 'section',
                            'controller'    => ListController::class
                        ],
                        'route' => 'crawler-manager list section'
                    ]
                ],
                'crontab_manager_update' => [
                    'options'   => [
                        'defaults'  => [
                            'action'        => 'index',
                            'controller'    => UpdateController::class
                        ],
                        'route' => 'crawler-manager update [-f] [-v]'
                    ]
                ]
            ]
        ]
    ]
];
