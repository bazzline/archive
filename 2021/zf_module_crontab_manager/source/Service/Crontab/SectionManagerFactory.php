<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-24
 */

namespace Net\Bazzline\Zf\CrontabManaer\Service\Crontab;

use Interop\Container\ContainerInterface;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Configuration;
use Zend\ServiceManager\Factory\FactoryInterface;

class SectionManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var Configuration $configuration */
        $configuration  = $container->get(Configuration::class);

        return new SectionManager(
            $configuration->getTemplateSectionConfiguration()->getSectionUniqueIdentifier()
        );
    }
}