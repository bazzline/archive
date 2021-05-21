<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-01
 */

return array(
    'controllers' => array(
        'factories' => array(
            'LocatorGenerator\Controller\Console\Index' => 'ZfLocatorGenerator\Controller\Console\IndexControllerFactory'
        )
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'locator_generate' => array(
                    'options' => array(
                        'route' => 'net_bazzline locator generate [<locator_name>] [--verbose]',
                        'defaults' => array(
                            'controller' => 'LocatorGenerator\Controller\Console\Index',
                            'action' => 'generate'
                        )
                    )
                ),
                'locator_list' => array(
                    'options' => array(
                        'route' => 'net_bazzline locator list',
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
            'NetBazzlineLocatorGeneratorProcessPipe' => 'ZfLocatorGenerator\Service\ProcessPipeFactory'
        )
    )
);
