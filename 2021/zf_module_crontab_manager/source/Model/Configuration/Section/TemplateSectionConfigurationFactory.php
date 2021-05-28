<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-16
 */

namespace Net\Bazzline\Zf\CrontabManaer\Model\Configuration\Section;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TemplateSectionConfigurationFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $configuration = $container->get('Config')['crontab_manager']['template'];

        return new TemplateSectionConfiguration(
            $configuration['root_path'] . DIRECTORY_SEPARATOR . $configuration['file_name_rendered_template'],
            $configuration['root_path'] . DIRECTORY_SEPARATOR . $configuration['file_name_template'],
            $configuration['list_of_template_key_to_value'],
            $configuration['section_unique_identifier']
        );
    }
}