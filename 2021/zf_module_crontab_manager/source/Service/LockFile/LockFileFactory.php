<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Service\LockFile;

use Interop\Container\ContainerInterface;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Configuration;
use Zend\ServiceManager\Factory\FactoryInterface;

class LockFileFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var Configuration $configuration */
        $configuration = $container->get(Configuration::class);

        return new LockFile(
            $configuration->getLockSectionConfiguration()->getFilePath(),
            $configuration->getLoggerInterface()
        );
    }
}