<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2016-02-04
 */
namespace Net\Bazzline\Component\ZendExpressiveTemplateAdapter;

use ArrayObject;
use Interop\Container\ContainerInterface;
use InvalidArgumentException;
use Net\Bazzline\Component\Template\AbstractFileBasedTemplate;

abstract class AbstractFileBasedTemplateAdapterFactory extends ExpressiveTemplateAdapter
{
    /**
     * @param ContainerInterface $container
     * @return ExpressiveTemplateAdapter
     *
     * section below is heavily inspired from:
     *  https://github.com/zendframework/zend-expressive-twigrenderer/blob/master/src/TwigRendererFactory.php
     *
     * Create and return a AbstractFileBased template instance.
     *
     * Optionally uses the service 'config', which should return an array. This
     * factory consumes the following structure:
     *
     * <code>
     * 'templates' => [
     *     'paths' => [
     *         // namespace / path pairs
     *         //
     *         // Numeric namespaces imply the default/main namespace. Paths may be
     *         // strings or arrays of string paths to associate with the namespace.
     *     ],
     * ],
     * </code>
     */
    public function __invoke(ContainerInterface $container)
    {
        $adapter        = new ExpressiveTemplateAdapter();
        $configuration  = $this->returnValidConfigurationOrThrowInvalidArgumentException(
            $container
        );

        $adapter->injectBaseTemplate($this->getAbstractFileBasedTemplate());

        $adapter = $this->addPathsFromConfiguration($adapter, $configuration);

        return $adapter;
    }

    /**
     * @return AbstractFileBasedTemplate
     */
    abstract protected function getAbstractFileBasedTemplate();

    /**
     * @param ExpressiveTemplateAdapter $adapter
     * @param array|ArrayObject $configuration
     * @return ExpressiveTemplateAdapter
     */
    private function addPathsFromConfiguration(ExpressiveTemplateAdapter $adapter, $configuration)
    {
        $configurationHasPathEntries = (
            (isset($configuration['templates']))
            && (isset($configuration['templates']['paths']))
            && (is_array($configuration['templates']['paths']))
            && (!empty($configuration['templates']['paths']))
        );

        if ($configurationHasPathEntries) {
            foreach ($configuration['templates']['paths'] as $possibleNamespace => $path) {
                $namespace = (is_numeric($possibleNamespace))
                    ? null
                    : $possibleNamespace;

                $adapter->addPath($path, $namespace);
            }
        }

        return $adapter;
    }

    /**
     * @param ContainerInterface $container
     * @return array|ArrayObject
     */
    private function returnValidConfigurationOrThrowInvalidArgumentException(Containerinterface $container)
    {
        $configuration  = $container->has('config')
            ? $container->get('config')
            : [];

        $configurationIsNotValid = (
            (!is_array($configuration))
            && (!$configuration instanceof ArrayObject)
        );

        if ($configurationIsNotValid) {
            throw new InvalidArgumentException(
                sprintf(
                    '"config" service must be an array or ArrayObject for the %s to be able to consume it; received %s',
                    __CLASS__,
                    (is_object($configuration) ? get_class($configuration) : gettype($configuration))
                )
            );
        }

        return $configuration;
    }
}