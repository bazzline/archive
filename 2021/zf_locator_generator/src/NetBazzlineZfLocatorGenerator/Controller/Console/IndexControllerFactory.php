<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-06-04
 */

namespace NetBazzlineZfLocatorGenerator\Controller\Console;

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
        $key            = 'net_bazzline_zf_locator_generator';

        if (!isset($configuration[$key])) {
            throw new InvalidArgumentException (
                'expected configuration key "' . $key . '" not found'
            );
        }

        $configuration  = $configuration[$key];
        /** @var PipeInterface $pipe */
        $pipe           = $serviceLocator->get('NetBazzlineLocatorGeneratorProcessPipe');

        $controller->setConfiguration($configuration);
        $controller->setProcessPipe($pipe);

        return $controller;
    }
}