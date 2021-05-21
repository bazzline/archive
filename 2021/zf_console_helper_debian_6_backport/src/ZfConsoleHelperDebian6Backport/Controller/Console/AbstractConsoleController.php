<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-09
 */

namespace ZfConsoleHelperDebian6Backport\Controller\Console;

use ZfConsoleHelper\Controller\Console\AbstractConsoleController as ParentClass;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\Console;

/**
 * Class AbstractConsoleController
 * @package LocatorGenerator\Controller\Console
 */
class AbstractConsoleController extends ParentClass
{
    /** @var AdapterInterface */
    private $console;

    //begin of console handling
    /**
     * Instantiate console if no is set
     * @return AdapterInterface
     */
    public function getConsole()
    {
        if (!($this->console instanceof AdapterInterface)) {
            $this->console = Console::getInstance();
        }

        return $this->console;
    }

    /**
     * @param AdapterInterface $console
     */
    public function setConsole(AdapterInterface $console)
    {
        $this->console = $console;
    }
    //end of console handling
}