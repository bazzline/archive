<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-09-15
 */

namespace Application\Controller\Console\Entity;

use Application\Feature\Console\V1\Output\Service\DynamicColumnWidthTableBuilder;
use Application\Feature\Storage\Service\GlobalStorageFactory;
use Application\Feature\Storage\Service\LocalStorageFactory;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ListControllerFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     *
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //begin of dependency
        //end of dependency

        //begin of business logic
        return new ListController(
            $container->get('Console'),
            $container->get(DynamicColumnWidthTableBuilder::class),
            $container->get(GlobalStorageFactory::VIRTUAL_INSTANCE_NAME),
            $container->get(LocalStorageFactory::VIRTUAL_INSTANCE_NAME)
        );
        //end of business logic
    }
}