<?php
/**
 * @author add_new_module.sh/0.0.1
 * @since 18-09-09
 */

use Application\Controller\Console\Entity\CreateController;
use Application\Controller\Console\Entity\ListController;
use Application\Controller\Console\System\AdjustController;
use Application\Controller\Console\System\AuditController;

return [
    //http routes
    'router' => [
        'routes' => [
                //'application_http_route_name'   => [
                //  'options'   => [
                //      'defaults'  => [
                //          'action'        => 'methodNameWithoutSuffixAction',
                //          'controller'    => \Application\Controller\Console\MyFancyController::class,
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
                //          'controller'    => \Application\Controller\Console\MyFancyController::class
                //      ],
                //      'route' => 'application my-console-command [--verbose|-v]
                //  ]
                //]
                'application_entity_create' => [
                    'options'   => [
                        'defaults'  => [
                            'action'        => 'index',
                            'controller'    => CreateController::class
                        ],
                        'route' => CreateController::ROUTE_NAME_WITHOUT_LIST_OF_ARGUMENT
                            . ' '
                            . CreateController::ROUTE_NAME_LIST_OF_ARGUMENT
                    ]
                ],
                'application_entity_list'   => [
                    'options'   => [
                        'defaults'  => [
                            'action'        => 'index',
                            'controller'    => ListController::class
                        ],
                        'route' => ListController::ROUTE_NAME_WITHOUT_LIST_OF_ARGUMENT
                            . ' '
                            . ListController::ROUTE_NAME_LIST_OF_ARGUMENT
                    ]
                ],
                'application_system_adjust' => [
                    'options'   => [
                        'defaults'  => [
                            'action'        => 'index',
                            'controller'    => AdjustController::class
                        ],
                        'route' => AdjustController::ROUTE_NAME_WITHOUT_LIST_OF_ARGUMENT
                            . ' '
                            . AdjustController::ROUTE_NAME_LIST_OF_ARGUMENT
                    ]
                ],
                'application_system_audit'  => [
                    'options'   => [
                        'defaults'  => [
                            'action'        => 'index',
                            'controller'    => AuditController::class
                        ],
                        'route' => AuditController::ROUTE_NAME_WITHOUT_LIST_OF_ARGUMENT
                            . ' '
                            . AuditController::ROUTE_NAME_LIST_OF_ARGUMENT
                    ]
                ]
            ]
        ]
    ]
];
