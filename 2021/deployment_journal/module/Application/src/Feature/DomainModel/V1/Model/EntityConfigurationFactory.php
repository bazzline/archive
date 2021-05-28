<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-12-15
 */

namespace Application\Feature\DomainModel\V1\Model;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class EntityConfigurationFactory implements FactoryInterface
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
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //begin of dependency
        $applicationConfiguration   = $container->get('Config');
        //end of dependency

        //begin of business logic
        $scopedConfiguration = $applicationConfiguration['application']['entity'];

        return new EntityConfiguration(
            $scopedConfiguration['list_of_affected_environments']
        );
        //end of business logic
    }
}