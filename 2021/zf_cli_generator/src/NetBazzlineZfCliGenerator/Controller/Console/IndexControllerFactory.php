<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-08
 */

namespace NetBazzlineZfCliGenerator\Controller\Console;

use Net\Bazzline\Component\ProcessPipe\PipeInterface;
use Zend\ServiceManager\Exception\InvalidArgumentException;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfConsoleHelper\Controller\Console\AbstractConsoleControllerFactory;

class IndexControllerFactory extends AbstractConsoleControllerFactory
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed|IndexController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $controller     = new IndexController();
        $serviceLocator = $this->transformIntoServiceManager($serviceLocator);

        /** @var array|\Zend\Config\Config $configuration */
        $configuration  = $serviceLocator->get('Config');
        $key            = 'net_bazzline_zf_cli_generator';

        if (!isset($configuration[$key])) {
            throw new InvalidArgumentException (
                'expected configuration key "' . $key . '" not found'
            );
        }

        /** @var PipeInterface $cliGenerator */
        $cliGenerator = $serviceLocator->get('NetBazzlineCliGeneratorGenerateCliContent');
        /** @var PipeInterface $configurationGenerator */
        $configurationGenerator = $serviceLocator->get('NetBazzlineCliGeneratorGenerateConfigurationContent');

        $configuration          = $configuration[$key];
        $pathToApplication      = $configuration['application']['path'] .
            DIRECTORY_SEPARATOR .
            $configuration['application']['name'];
        $pathToAutoload         = $configuration['autoload']['path'] .
            DIRECTORY_SEPARATOR .
            $configuration['autoload']['name'];
        $pathToConfiguration    = $configuration['configuration']['target']['path'] .
            DIRECTORY_SEPARATOR .
            $configuration['configuration']['target']['name'];
        $pathToCli              = $configuration['cli']['target']['path'] .
            DIRECTORY_SEPARATOR .
            $configuration['cli']['target']['name'];
        $prefix                 = $configuration['cli']['prefix'];

        $controller->injectGenerateConfigurationProcessPipe($configurationGenerator);
        $controller->injectGenerateCliProcessPipe($cliGenerator);
        $controller->injectPathToApplication($pathToApplication);
        $controller->injectPathToAutoload($pathToAutoload);
        $controller->injectPathToConfiguration($pathToConfiguration);
        $controller->injectPathToCli($pathToCli);
        $controller->injectPrefix($prefix);

        return $controller;
    }
}
