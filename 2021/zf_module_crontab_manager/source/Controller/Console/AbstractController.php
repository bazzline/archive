<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2019-03-24
 */

namespace Net\Bazzline\Zf\CrontabManaer\Controller\Console;

use Throwable;
use Zend\Console\Adapter\AdapterInterface;
use Zend\Console\ColorInterface;
use Zend\Console\Request;
use Zend\Console\Response;
use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractController extends AbstractActionController
{
    /**
     * @return \Zend\Stdlib\RequestInterface|Request
     */
    public function getRequest()
    {
        return parent::getRequest(); // TODO: Change the autogenerated stub
    }

    /**
     * @return \Zend\Stdlib\ResponseInterface|Response
     */
    public function getResponse()
    {
        return parent::getResponse(); // TODO: Change the autogenerated stub
    }

    protected function beVerbose() : bool
    {
        return (!is_null($this->getRequest()->getParam('v')));
    }

    protected function handleThrowable(
        AdapterInterface $adapter,
        Response $response,
        Throwable $throwable
    ) : Response {
        $adapter->writeLine(
            ':: Throwable class.' . PHP_EOL,
            ColorInterface::RED
        );
        $adapter->writeLine(
            '   ' . get_class($throwable),
            ColorInterface::RESET
        );

        $adapter->writeLine(
            ':: Throwable message.' . PHP_EOL,
            ColorInterface::RED
        );
        $adapter->writeLine(
            '   ' . $throwable->getMessage(),
            ColorInterface::RESET
        );

        $adapter->writeLine(
            ':: Throwable trace.' . PHP_EOL,
            ColorInterface::RED
        );
        $adapter->writeLine(
            '   ' . $throwable->getTraceAsString(),
            ColorInterface::RESET
        );

        $response->setErrorLevel(1);

        return $response;
    }

    protected function isForced() : bool
    {
        return (!is_null($this->getRequest()->getParam('f')));
    }
}