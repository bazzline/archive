<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-30
 */

namespace Net\Bazzline\Zf\CrontabManaer\Service\Storage;

use Interop\Container\ContainerInterface;
use Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Configuration;
use Zend\ServiceManager\Factory\FactoryInterface;

class ArchiveManagerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     *
     * @return ArchiveManager|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var Configuration $configuration */
        $configuration = $container->get(Configuration::class);

        return new ArchiveManager(
            $configuration->getDumpSectionConfiguration()->getArchiverDumpSectionConfiguration()->getNumberOfFullDumpsToKeep(),
            $configuration->getDumpSectionConfiguration()->getArchiverDumpSectionConfiguration()->isArchiveFullDump()
        );
    }
}