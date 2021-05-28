<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-09-15
 */

return [
    'log' => [
        'ApplicationCoreLogger' => [
            'writers' => [
                'log_file_application' => [
                    'name'      => \Zend\Log\Writer\Stream::class,
                    'priority'  => \Zend\Log\Logger::ALERT, //will receive the log message as one first
                    'options'   => [
                        //'stream'    => 'php://output',
                        'stream'    => __DIR__ . '/../../../data/log/application.log',
                        'formatter' => [
                            'name'      => \Zend\Log\Formatter\Simple::class,
                            'options'   => [
                                'dateTimeFormat'    => 'c', //looks like: 2018-09-15T09:45:40+02:00
                                'format'            => '%timestamp% %priorityName% (%priority%): %message% %extra%' //looks like: 2018-09-15T09:45:40+02:00 DEBUG (7): my debug log message
                            ]
                        ],
                        'filters'   => [
                            'priority'  => [
                                'name'      => 'priority',
                                'options'   => [
                                    'operator'  => '<=',
                                    'priority'  => \Zend\Log\Logger::DEBUG  //allows all log level message
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'processors' => [
                'requestid' => [
                    'name' => \Zend\Log\Processor\RequestId::class,
                ],
            ]
        ]
    ],
    'service_manager' => [
        'aliases' => [
            \Zend\Log\Logger::class => 'ApplicationCoreLogger'
        ]
    ]
];
