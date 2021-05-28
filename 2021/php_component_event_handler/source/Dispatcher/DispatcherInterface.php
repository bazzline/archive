<?php
/**
 * @author: stev leibelt <artodeto@bazzline.net>
 * @since: 2016-09-01
 */
namespace Net\Bazzline\Component\EventHandler\Dispatcher;

use Net\Bazzline\Component\EventHandler\Listener\ListenerInterface;
use Net\Bazzline\Component\Event\EventInterface;

interface DispatcherInterface
{
    /**
     * @param string $fullQualifiedClassName
     * @param ListenerInterface $listener
     */
    public function attachListenerByEventClass($fullQualifiedClassName, ListenerInterface $listener);

    /**
     * @param string $name
     * @param ListenerInterface $listener
     */
    public function attachListenerByEventName($name, ListenerInterface $listener);

    /**
     * @param string $fullQualifiedClassName
     * @param ListenerInterface $listener
     */
    public function detachListenerByEventClass($fullQualifiedClassName, ListenerInterface $listener);

    /**
     * @param string $name
     * @param ListenerInterface $listener
     */
    public function detachListenerByEventName($name, ListenerInterface $listener);

    /**
     * @param EventInterface $event
     */
    public function dispatch(EventInterface $event);
}
