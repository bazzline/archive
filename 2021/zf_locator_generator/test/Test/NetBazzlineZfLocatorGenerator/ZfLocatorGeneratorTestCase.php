<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-06 
 */

namespace Test\NetBazzlineZfLocatorGenerator;

use PHPUnit_Framework_TestCase;
use Mockery;
use Zend\Stdlib\Parameters;

/**
 * Class ZfLocatorGeneratorTestCase
 * @package Test\NetBazzlineZfLocatorGenerator
 */
class ZfLocatorGeneratorTestCase extends PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mockery::close();
    }

    /**
     * @return Mockery\MockInterface|\Zend\Console\Adapter\AdapterInterface
     */
    protected function getMockOfConsole()
    {
        return Mockery::mock('Zend\Console\Adapter\AdapterInterface');
    }

    /**
     * @return Mockery\MockInterface|\Net\Bazzline\Component\ProcessPipe\PipeInterface
     */
    protected function getMockOfProcessPipeInterface()
    {
        return Mockery::mock('Net\Bazzline\Component\ProcessPipe\PipeInterface');
    }

    /**
     * @return Mockery\MockInterface|\Zend\ServiceManager\ServiceLocatorInterface
     */
    protected function getMockOfServiceLocator()
    {
        return Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
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