<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Model\Configuration;

use Interop\Container\ContainerInterface;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\DumpSectionConfiguration;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\LockSectionConfiguration;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section\TemplateSectionConfiguration;
use Zend\ServiceManager\Factory\FactoryInterface;

class ConfigurationFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $configuration  = $container->get('Config')['crontab_manager'];

        return new Configuration(
            $container->get(DumpSectionConfiguration::class),
            $container->get(LockSectionConfiguration::class),
            $container->get($configuration['logger']),
            $container->get(TemplateSectionConfiguration::class)
        );
    }
}