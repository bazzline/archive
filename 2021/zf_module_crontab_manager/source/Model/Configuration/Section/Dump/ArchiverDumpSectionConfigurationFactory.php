<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\Dump;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ArchiverDumpSectionConfigurationFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $configuration = $container->get('Config');

        return new ArchiverDumpSectionConfiguration(
            $configuration['crontab_manager']['dump']['archiver']['archive_full_dump'],
            $configuration['crontab_manager']['dump']['archiver']['number_of_full_dumps_to_keep']
        );
    }
}