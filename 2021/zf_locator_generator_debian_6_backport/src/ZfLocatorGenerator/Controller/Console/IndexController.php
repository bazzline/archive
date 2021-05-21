<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-02 
 */

namespace ZfLocatorGenerator\Controller\Console;

use Exception;
use InvalidArgumentException;
use Net\Bazzline\Component\ProcessPipe\PipeInterface;
use Zend\Console\ColorInterface;
use ZfConsoleHelper\Controller\Console\AbstractConsoleController;

class IndexController extends AbstractConsoleController
{
    /** @var array */
    private $configuration;

    /** @var PipeInterface */
    private $processPipe;

    /**
     * @param array $configuration
     */
    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param PipeInterface $processPipe
     */
    public function setProcessPipe(PipeInterface $processPipe)
    {
        $this->processPipe = $processPipe;
    }



    public function generateAction()
    {
        $beVerbose      = $this->beVerbose();

        $configuration  = $this->configuration;
        $console        = $this->getConsole();
        $processPipe    = $this->processPipe;

        try {
            $this->throwExceptionIfNotCalledInsideAnCliEnvironment();
            $configuration = $configuration['name_to_configuration_path'];

            if ($this->hasParameter('locator_name')) {
                $locatorName = $this->getParameter('locator_name');

                if (!isset($configuration[$locatorName])) {
                    throw new InvalidArgumentException(
                        'invalid locator name provided'
                    );
                }

                $namesToPath = array($locatorName => $configuration[$locatorName]);
            } else {
                $namesToPath = $configuration;
            }

            //@todo implement usage of $this->processItems();
            foreach ($namesToPath as $name => $path) {
                if ($beVerbose) {
                    $console->writeLine(
                        'generating "' . $name . '" by using configuration file "' . $path . '"'
                    );
                } else {
                    $console->write('.');
                }

                $arguments = array(
                    __FILE__,
                    $path
                );

                try {
                    $processPipe->execute($arguments);
                } catch (Exception $exception) {
                    $console->setColor(ColorInterface::LIGHT_RED);
                    $console->writeLine('could not generate locator for "' . $name . '"');
                    $console->writeLine('error: ' . $exception->getMessage());
                    $console->resetColor();
                }
            }
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    public function listAction()
    {
        $configuration  = $this->configuration;
        $console        = $this->getConsole();

        try {
            $this->throwExceptionIfNotCalledInsideAnCliEnvironment();

            $configuration = $configuration['name_to_configuration_path'];

            foreach ($configuration as $name => $path) {
                $console->writeLine('locator: ' . $name . ' with configuration file "' . $path . '"');
            }
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    /**
     * @return bool
     */
    protected function beVerbose()
    {
        return $this->hasBooleanParameter('v', 'verbose');
    }
}