<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-08
 */

namespace Test\NetBazzlineZfCliGenerator;

use Net\Bazzline\Component\ProcessPipe\PipeInterface;
use NetBazzlineZfCliGenerator\Service\ProcessPipe\Filter\RemoveColorsAndModuleHeadlines;
use PHPUnit_Framework_TestCase;
use Mockery;
use Zend\Console\Adapter\AdapterInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Parameters;

/**
 * Class ZfCliGeneratorTestCase
 * @package Test\NetBazzlineZfCliGenerator
 */
class ZfCliGeneratorTestCase extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * @return string
     */
    protected function getExampleOutput()
    {
        return <<<EOF
Zf Index - Version 1.0.0
Net\Bazzline Zf Locator Generator - Version 1.0.0

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
Application
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  index.php console index [--verbose]    run index

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
NetBazzlineZfCliGenerator
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

  index.php net_bazzline locator generate [<locator_name>] [--verbose]    run generation of locator depending on your configuration
  index.php net_bazzline locator list                                     list available locator with configuration path

Reason for failure: Invalid arguments or no arguments provided
EOF;
    }

    /**
     * @return Mockery\MockInterface|AdapterInterface
     */
    protected function getMockOfConsole()
    {
        return Mockery::mock(AdapterInterface::class);
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\ProcessPipe\PipeInterface
     */
    protected function getMockOfProcessPipeInterface()
    {
        return Mockery::mock(PipeInterface::class);
    }

    /**
     * @return Mockery\MockInterface|ServiceLocatorInterface
     */
    protected function getMockOfServiceLocator()
    {
        return Mockery::mock(ServiceLocatorInterface::class);
    }

    /**
     * @return RemoveColorsAndModuleHeadlines
     */
    protected function getNewRemoveColorsAndModuleHeadlines()
    {
        return new RemoveColorsAndModuleHeadlines();
    }

    /**
     * @param array $array
     * @return Parameters
     */
    protected function getParameters(array $array = null)
    {
        return new Parameters($array);
    }
}