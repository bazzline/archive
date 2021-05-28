<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-01
 */

return array(
    'controllers' => array(
        'factories' => array(
            'LocatorGenerator\Controller\Console\Index' => 'NetBazzlineZfLocatorGenerator\Controller\Console\IndexControllerFactory'
        )
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'net_bazzline_locator_generate' => array(
                    'options' => array(
                        'route' => 'net_bazzline locator_generator generate [<locator_name>] [--verbose]',
                        'defaults' => array(
                            'controller' => 'LocatorGenerator\Controller\Console\Index',
                            'action' => 'generate'
                        )
                    )
                ),
                'net_bazzlin_locator_list' => array(
                    'options' => array(
                        'route' => 'net_bazzline locator_generator list',
                        'defaults' => array(
                            'controller' => 'LocatorGenerator\Controller\Console\Index',
                            'action' => 'list'
                        )
                    )
                )
            )
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'NetBazzlineLocatorGeneratorProcessPipe' => 'NetBazzlineZfLocatorGenerator\Service\ProcessPipeFactory'
        )
    )
);
