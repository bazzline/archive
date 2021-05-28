<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section;

use Interop\Container\ContainerInterface;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\Dump\ArchiverDumpSectionConfiguration;
use Zend\ServiceManager\Factory\FactoryInterface;

class DumpSectionConfigurationFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $configuration = $container->get('Config')['crontab_manager']['dump'];

        return new DumpSectionConfiguration(
            $container->get(ArchiverDumpSectionConfiguration::class),
            $configuration['root_path'] . DIRECTORY_SEPARATOR . $configuration['file_name_full_dump'],
            $configuration['root_path'] . DIRECTORY_SEPARATOR . $configuration['file_name_section_dump'],
            $configuration['root_path'] . DIRECTORY_SEPARATOR . $configuration['file_name_updated_dump']
        );
    }
}