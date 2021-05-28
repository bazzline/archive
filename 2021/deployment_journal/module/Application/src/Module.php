<?php
/**
 * @author add_new_module.sh/0.0.1
 * @since 18-09-09
 */

namespace Application;

use Application\Controller\Console\Entity\CreateController;
use Application\Controller\Console\Entity\ListController;
use Application\Controller\Console\System\AdjustController;
use Application\Controller\Console\System\AuditController;
use Psr\Log\LoggerInterface;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\EventManager\EventInterface;
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
        $configuration = [];

        foreach (Glob::glob(__DIR__ . '/../config/{,*.}config.php', Glob::GLOB_BRACE) as $file) {
            $fileContent = include $file;
            $fileArray = is_array($fileContent) ? $fileContent : [];
            $configuration = ArrayUtils::merge($configuration, $fileArray);
        }

        return $configuration;
    }
    //end of ConfigProviderInterface

    //begin of ConsoleUsageProviderInterface
    /**
     * @param Console $console
     * @return array
     */
    public function getConsoleUsage(Console $console) : array
    {
        return [
            CreateController::ROUTE_NAME_WITHOUT_LIST_OF_ARGUMENT
                . ' '
                . CreateController::ROUTE_NAME_LIST_OF_ARGUMENT     => 'Add a new entity to the journal.',
            ListController::ROUTE_NAME_WITHOUT_LIST_OF_ARGUMENT
                . ' '
                . ListController::ROUTE_NAME_LIST_OF_ARGUMENT       => 'Show entities in the journal.',
            AdjustController::ROUTE_NAME_WITHOUT_LIST_OF_ARGUMENT
                . ' '
                . AdjustController::ROUTE_NAME_LIST_OF_ARGUMENT     => 'Synchronise local journal to the state of the global journal.',
            AuditController::ROUTE_NAME_WITHOUT_LIST_OF_ARGUMENT
                . ' '
                . AuditController::ROUTE_NAME_LIST_OF_ARGUMENT      => '@todo',
        ];
    }
    //end of ConsoleUsageProviderInterface
}
