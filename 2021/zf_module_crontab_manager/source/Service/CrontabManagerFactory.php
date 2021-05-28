<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-24
 */

namespace Net\Bazzline\Zf\CrontabManaer\Service;

use Interop\Container\ContainerInterface;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Configuration;
use Net\Bazzline\Zf\CrontabManaer\Service\Crontab\CrontabService;
use Net\Bazzline\Zf\CrontabManaer\Service\Crontab\SectionManager;
use Net\Bazzline\Zf\CrontabManaer\Service\LockFile\LockFile;
use Net\Bazzline\Zf\CrontabManaer\Service\Storage\FileStorage;
use Net\Bazzline\Zf\CrontabManaer\Service\Template\Renderer;
use Zend\ServiceManager\Factory\FactoryInterface;

class CrontabManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CrontabManager(
            $container->get(Configuration::class),
            $container->get(CrontabService::class),
            $container->get(FileStorage::class),
            $container->get(LockFile::class),
            $container->get(Renderer::class),
            $container->get(SectionManager::class)
        );
    }
}