<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-30
 */

namespace Net\Bazzline\Zf\CrontabManaer\Controller\Console;

use Interop\Container\ContainerInterface;
use Net\Bazzline\Zf\CrontabManaer\Service\CrontabManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class DisableControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     *
     * @return DisableController|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new DisableController(
            $container->get('Console'),
            $container->get(CrontabManager::class)
        );
    }
}