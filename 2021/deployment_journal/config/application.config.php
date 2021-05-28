<?php
/**
 * @author create_application.sh/0.0.1
 * @since 18-09-09
 */

$listOfModule = [
    //ordered by priority
    //begin of zend modules
    'Zend\Log',
    'Zend\Mvc\Console',
    'Zend\Router',
    'Zend\Validator',
    //end of zend modules

    //begin of other third party modules
    //end of other third party modules

    //begin of application module
    'Application'
    //end of application module
];

//@see:
//  https://github.com/zendframework/ZendSkeletonApplication/blob/master/config/application.config.php
//  vendor/zendframework/zend-mvc/docs/book/services.md
//  https://docs.zendframework.com/zend-modulemanager/
//  https://framework.zend.com/manual/2.4/en/tutorials/config.advanced.html

return [
    'modules' => $listOfModule,
    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => [
        // This should be an array of paths in which modules reside.
        // If a string key is provided, the listener will consider that a module
        // namespace, the value of that key the specific path to that module's
        // Module class.
        'module_paths' => [
            './module',
            './vendor',
        ],
        // An array of paths from which to glob configuration files after
        // modules are loaded. These effectively override configuration
        // provided by modules themselves. Paths may use GLOB_BRACE notation.
        'config_glob_paths' => [
            realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php',
        ],
        // Whether or not to enable a configuration cache.
        // If enabled, the merged configuration will be cached and used in
        // subsequent requests.
        'config_cache_enabled' => false,    //set this to true on production
        // The key used to create the configuration cache file name.
        'config_cache_key' => 'application.config.cache',
        // Whether or not to enable a module class map cache.
        // If enabled, creates a module class map cache which will be used
        // by in future requests, to reduce the autoloading process.
        'module_map_cache_enabled' => false,    //set this to true on production
        // The key used to create the class map cache file name.
        'module_map_cache_key' => 'application.module.cache',
        // The path in which to cache merged configuration.
        'cache_dir' => 'data/cache/',
        // Whether or not to enable modules dependency checking.
        // Enabled by default, prevents usage of modules that depend on other modules
        // that weren't loaded.
        // 'check_dependencies' => true,
    ],
    // Used to create an own service manager. May contain one or more child arrays.
    // 'service_listener_options' => [
    //     [
    //         'service_manager' => ,
    //         'config_key'      => ,
    //         'interface'       => ,
    //         'method'          => ,
    //     ],
    // ],
    // Initial configuration with which to seed the ServiceManager.
    // Should be compatible with Zend\ServiceManager\Config.
    // 'service_manager' => [],
];
