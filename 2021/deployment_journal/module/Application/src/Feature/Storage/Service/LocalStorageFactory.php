<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2018-09-15
 */

namespace Application\Feature\Storage\Service;

use Application\Service\BuilderInterface;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use InvalidArgumentException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class LocalStorageFactory implements FactoryInterface
{
    const VIRTUAL_INSTANCE_NAME = __CLASS__ . '_instance';
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
        $configuration  = $container->get('Config');
        //end of dependency

        //begin of business logic
        $storageClass   = $configuration['application']['storage']['local'][StorageInterface::class];
        $storageOptions = $configuration['application']['storage']['local']['options'];

        switch($storageClass) {
            case FileSystemStorage::class:
                /** @var BuilderInterface $builder */
                $builder = $container->get(FilesystemStorageBuilder::class);
                break;
            default:
                throw new InvalidArgumentException(
                    sprintf(
                        'Unsupported global storage class >>%s<<.',
                        $storageClass
                    )
                );
        }

        return $builder->build(
            $storageOptions
        );
        //end of business logic
    }
}