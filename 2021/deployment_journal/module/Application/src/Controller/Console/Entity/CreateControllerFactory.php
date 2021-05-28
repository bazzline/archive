<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-09-15
 */

namespace Application\Controller\Console\Entity;

use Application\Feature\Console\V1\Input\Service\FetchInput;
use Application\Feature\DomainModel\V1\Model\EntityConfiguration;
use Application\Feature\Storage\Service\GlobalStorageFactory;
use Application\Service\Generator\CurrentDateTimeGenerator;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class CreateControllerFactory implements FactoryInterface
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
        return new CreateController(
            $container->get('Console'),
            $container->get(CurrentDateTimeGenerator::class),
            $container->get(EntityConfiguration::class),
            $container->get(FetchInput::class),
            $container->get(GlobalStorageFactory::VIRTUAL_INSTANCE_NAME)
        );
    }
}