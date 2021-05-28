#!/usr/bin/env bash
####
# Simple script to automate the creation of a new zend framework module
#
# @todo
#   move code into functions
#   add userinput
#   automate the manual steps at the end
####
# @author stev leibelt <artodeto@bazzline.net>
# @since 2018-05-13
####

CURRENT_DATE=$(date +'%y-%m-%d')
CURREMT_VERSION="0.0.1"
CURRENT_WORKING_DIRECTORY=$(pwd);

NAME_OF_THE_CURRENT_SCRIPT=$(basename "${BASH_SOURCE[0]}");
PATH_OF_THE_CURRENT_SCRIPT=$(cd $(dirname "${BASH_SOURCE[0]}"); pwd);

function print_usage_and_exit
{
    echo ":: Invalid amount of arguments supplied."
    echo "   Usage: ${NAME_OF_THE_CURRENT_SCRIPT} <module name> [<application path>]"
    echo ""

    exit 1;
}

if [[ $# -lt 1 ]];
then
    print_usage_and_exit;
fi

MODULE_NAME="${1}"

if [[ $# -gt 1 ]];
then
    PATH_TO_THE_APPLICATION="${2}"
else
    PATH_TO_THE_APPLICATION="."
fi

MODULE_NAME_AS_LOWER_CASE=$(echo "${MODULE_NAME}" | tr '[:upper:]' '[:lower:]')
PATH_TO_THE_NEW_MODULE="${PATH_TO_THE_APPLICATION}/module/${MODULE_NAME}"

if [[ ! -d "${PATH_TO_THE_APPLICATION}/module" ]];
then
    echo ":: No module path found!"
    echo "   Can not create new module"
    echo ""

    exit 2;
fi

if [[ -d "${PATH_TO_THE_NEW_MODULE}" ]];
then
    echo ":: Module with the name >>${MODULE_NAME}<< exists already!"
    echo ""

    exit 3;
fi

cd "${PATH_TO_THE_APPLICATION}"

echo ":: Creating directories."

/usr/bin/env mkdir "module/${MODULE_NAME}"

cd "module/${MODULE_NAME}"

/usr/bin/env mkdir -p config
/usr/bin/env mkdir -p src/{Controller,Model,Service}
/usr/bin/env mkdir -p src/Controller/{Http,Console}
/usr/bin/env mkdir -p test/phpunit/{Model,Service}

echo ":: Creating files."

touch README.md phpunit.xml src/Module.php config/module.config.php "config/${MODULE_NAME_AS_LOWER_CASE}.config.php" config/routes.config.php test/phpunit/bootstrap.php

cat > README.md <<DELIM
# ${MODULE_NAME} Domain

DELIM

cat > phpunit.xml <<DELIM
<phpunit
    bootstrap="test/phpunit/bootstrap.php"
    colors="true"
    backupGlobals="true"
    convertErrorsToExceptions="true"
    convertNoticesToExceptions="true"
    convertWarningsToExceptions="true"
    stopOnFailure="false">

    <php>
        <server name='HTTP_HOST' value='http://localhost' />
        <server name="SERVER_NAME" value='http://localhost' />
        <server name="SERVER_PORT" value="80"/>
    </php>

    <testsuites>
        <testsuite name="${MODULE_NAME} Test Suite">
            <directory>./test/phpunit</directory>
        </testsuite>
    </testsuites>
</phpunit>
DELIM

cat > src/Module.php <<DELIM
<?php
/**
 * @author ${NAME_OF_THE_CURRENT_SCRIPT}/${CURREMT_VERSION}
 * @since ${CURRENT_DATE}
 */

namespace ${MODULE_NAME};

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Stdlib\Glob;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Module
 * @see:
 *  https://docs.zendframework.com/zend-modulemanager/
 *  https://framework.zend.com/manual/2.4/en/tutorials/config.advanced.html#module-configuration
 */
class Module implements ConfigProviderInterface, ConsoleUsageProviderInterface
{
    //begin of ConfigProviderInterface
    /**
     * @return array
     * @throws \Zend\Stdlib\Exception\RuntimeException
     */
    public function getConfig() : array
    {
        \$configuration = [];

        foreach (Glob::glob(__DIR__ . '/../config/{,*.}config.php', Glob::GLOB_BRACE) as \$file) {
            \$fileContent = include \$file;
            \$fileArray = is_array(\$fileContent) ? \$fileContent : [];
            \$configuration = ArrayUtils::merge(\$configuration, \$fileArray);
        }

        return \$configuration;
    }
    //end of ConfigProviderInterface

    //begin of ConsoleUsageProviderInterface
    /**
     * @param Console \$console
     * @return array
     */
    public function getConsoleUsage(Console \$console) : array
    {
        return [
            //alphabetically order!
        ];
    }
    //end of ConsoleUsageProviderInterface
}
DELIM

cat > config/module.config.php <<DELIM
<?php
/**
 * @author ${NAME_OF_THE_CURRENT_SCRIPT}/${CURREMT_VERSION}
 * @since ${CURRENT_DATE}
 */

return [
    //begin of zend framework configuration section
    'controllers' => [
        'factories' => [
            //console
            //http
        ]
    ],
    'service_manager' => [
        'invokables' => [
        ],
        'factories' => [
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
DELIM

cat > "config/${MODULE_NAME_AS_LOWER_CASE}.config.php" <<DELIM
<?php
/**
 * @author ${NAME_OF_THE_CURRENT_SCRIPT}/${CURREMT_VERSION}
 * @since ${CURRENT_DATE}
 */

return [
    //begin of module configuration section
    '${MODULE_NAME_AS_LOWER_CASE}' => [
    ]
    //end of module configuration section
];
DELIM

cat > config/routes.config.php <<DELIM
<?php
/**
 * @author ${NAME_OF_THE_CURRENT_SCRIPT}/${CURREMT_VERSION}
 * @since ${CURRENT_DATE}
 */

return [
    //http routes
    'router' => [
        'routes' => [
                //'${MODULE_NAME_AS_LOWER_CASE}_http_route_name'   => [
                //  'options'   => [
                //      'defaults'  => [
                //          'action'        => 'methodNameWithoutSuffixAction',
                //          'controller'    => \\${MODULE_NAME}\Controller\Console\MyFancyController::class,
                //          'module'        => '${MODULE_NAME}'
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
                //'${MODULE_NAME_AS_LOWER_CASE}_console_route_name'   => [
                //  'options'   => [
                //      'defaults'  => [
                //          'action'        => 'methodNameWithoutSuffixAction',
                //          'controller'    => \\${MODULE_NAME}\Controller\Console\MyFancyController::class
                //      ],
                //      'route' => '${MODULE_NAME_AS_LOWER_CASE} my-console-command [--verbose|-v]
                //  ]
                //]
            ]
        ]
    ]
];
DELIM

cat > test/phpunit/bootstrap.php <<DELIM
<?php
/**
 * @author ${NAME_OF_THE_CURRENT_SCRIPT}/${CURREMT_VERSION}
 * @since ${CURRENT_DATE}
 */

\$basePath = realpath(__DIR__ . '/../../../../');
putenv('SYSTEM_ENVIRONMENT=unittest');
date_default_timezone_set('Europe/Berlin');

//setup autoloader
require_once \$basePath . '/../vendor/autoload.php';
DELIM

echo ":: Attantion!"
echo "   Please adapt the the file \"application.config.php\" in the path \"${PATH_TO_THE_APPLICATION}/config\"."
echo "   You have to add '${MODULE_NAME}' inside the declaration of \$module."
echo ""

echo "   Please adapt the file \"composer.json\" in the path \"${PATH_TO_THE_APPLICATION}\"."
echo "   You have to add '\"${MODULE_NAME}\\\\\": \"module/${MODULE_NAME}/src/\",' in the PSR-4 section."
echo "   Execute \"ant composer_install_development\" in the path \"${PATH_TO_THE_APPLICATION}\"."

cd "${CURRENT_WORKING_DIRECTORY}"
