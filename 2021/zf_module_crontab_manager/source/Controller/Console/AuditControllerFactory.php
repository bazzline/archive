<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-24
 */

namespace Net\Bazzline\Zf\CrontabManaer\Controller\Console;

use Interop\Container\ContainerInterface;
use Net\Bazzline\Zf\CrontabManaer\Service\CrontabManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class AuditControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AuditController(
            $container->get('Console'),
            $container->get(CrontabManager::class)
        );
    }
}