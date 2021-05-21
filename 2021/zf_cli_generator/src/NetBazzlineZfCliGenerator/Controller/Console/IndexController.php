<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-08
 */

namespace NetBazzlineZfCliGenerator\Controller\Console;

use Exception;
use Net\Bazzline\Component\ProcessPipe\PipeInterface;
use NetBazzlineZfCliGenerator\Service\ProcessPipe\Transformer\DumpCliContent;
use ZfConsoleHelper\Controller\Console\AbstractConsoleController;

class IndexController extends AbstractConsoleController
{
    /** @var PipeInterface */
    private $generateCli;

    /** @var PipeInterface */
    private $generateConfiguration;

    /** @var string */
    private $pathToApplication;

    /** @var string */
    private $pathToAutoload;

    /** @var string */
    private $pathToCli;

    /** @var string */
    private $pathToConfiguration;

    /** @var string */
    private $prefix;

    /**
     * @param PipeInterface $processPipe
     */
    public function injectGenerateCliProcessPipe(PipeInterface $processPipe)
    {
        $this->generateCli = $processPipe;
    }

    /**
     * @param PipeInterface $processPipe
     */
    public function injectGenerateConfigurationProcessPipe(PipeInterface $processPipe)
    {
        $this->generateConfiguration = $processPipe;
    }

    /**
     * @param string $path
     */
    public function injectPathToApplication($path)
    {
        $this->pathToApplication = $path;
    }

    /**
     * @param string $path
     */
    public function injectPathToAutoload($path)
    {
        $this->pathToAutoload = $path;
    }

    /**
     * @param string $path
     */
    public function injectPathToCli($path)
    {
        $this->pathToCli = $path;
    }

    /**
     * @param string $path
     */
    public function injectPathToConfiguration($path)
    {
        $this->pathToConfiguration = $path;
    }

    /**
     * @param string $prefix
     */
    public function injectPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    public function configurationAction()
    {
        //begin of dependencies
        $console                = $this->getConsole();
        $pathToApplication      = $this->pathToApplication;
        $pathToConfiguration    = $this->pathToConfiguration;
        $processPipe            = $this->generateConfiguration;
        //end of dependencies

        try {
            $this->throwExceptionIfNotCalledInsideAnCliEnvironment();

            //@todo replace by something form zend
            $content = $processPipe->execute($pathToApplication);
            $this->tryToWriteContent($pathToConfiguration, $content);
            $console->writeLine('generated configuration in path: "' . $pathToConfiguration . '"');
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }

    public function cliAction()
    {
        //begin of dependencies
        $console                = $this->getConsole();
        $pathToApplication      = $this->pathToApplication;
        $pathToAutoload         = $this->pathToAutoload;
        $pathToConfiguration    = $this->pathToConfiguration;
        $pathToCli              = $this->pathToCli;
        $prefix                 = $this->prefix;
        $processPipe            = $this->generateCli;
        //end of dependencies

        try {
            $this->throwExceptionIfNotCalledInsideAnCliEnvironment();

            //workflow
            //  generate cli file using the template
            //  this file also contains the closure used in the configuration to execute the code
            $input                  = array(
                DumpCliContent::INPUT_KEY_PATH_TO_APPLICATION   => $pathToApplication,
                DumpCliContent::INPUT_KEY_PATH_TO_AUTOLOAD      => $pathToAutoload,
                DumpCliContent::INPUT_KEY_PATH_TO_CLI           => $pathToCli,
                DumpCliContent::INPUT_KEY_PATH_TO_CONFIGURATION => $pathToConfiguration,
                DumpCliContent::INPUT_KEY_PREFIX_CLI            => $prefix
            );
            //we need to make sure the file exist
            if (!file_exists($pathToCli)) {
                $this->tryToWriteContent($pathToCli, '');
            }
            $content = $processPipe->execute($input);
            $this->tryToWriteContent($pathToCli, $content);
            chmod($pathToCli, 0755);
            $console->writeLine('generated cli in path: "' . $pathToCli . '"');
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

    /**
     * @param string $path
     * @param mixed $content
     * @throws Exception
     */
    private function tryToWriteContent($path, $content)
    {
        $contentCouldBeWritten  = (file_put_contents($path, $content) !== false);

        if (!$contentCouldBeWritten) {
            throw new Exception(
                'could not write to path "' . $path . '"'
            );
        }
    }
}