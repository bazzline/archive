<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since: 2016-08-29
 */
namespace Net\Bazzline\Component\Event;

use DateTime;
use RuntimeException;

class GenericEventBuilder
{
    /** @var DateTime */
    private $emittedAt;

    /** @var string */
    private $name;

    /** @var string */
    private $source;

    /** @var array|object */
    private $subject;

    /**
     * @param string $name
     */
    public function setMandatoryName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $source
     */
    public function setMandatorySource($source)
    {
        $this->source = $source;
    }

    /**
     * @param array|object $subject
     */
    public function setMandatorySubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param DateTime $emittedAt
     */
    public function setOptionalEmittedAt(DateTime $emittedAt)
    {
        $this->emittedAt = $emittedAt;
    }

    /**
     * @return GenericEvent
     * @throws RuntimeException
     */
    public function build()
    {
        $this->throwRuntimeExceptionIfNotAllMandatoryPropertiesAreSet();

        $event = new GenericEvent(
            $this->emittedAt,
            $this->name,
            $this->source,
            $this->subject
        );

        $this->reset();

        return $event;
    }

    private function reset()
    {
        $this->emittedAt    = new DateTime();
        $this->name         = null;
        $this->source       = null;
        $this->subject      = null;
    }

    /**
     * @throws RuntimeException
     */
    private function throwRuntimeExceptionIfNotAllMandatoryPropertiesAreSet()
    {
        if (is_null($this->name)) {
            throw new RuntimeException('mandatory property >>name<< not provided');
        }

        if (is_null($this->source)) {
            throw new RuntimeException('mandatory property >>source<< not provided');
        }

        if (is_null($this->subject)) {
            throw new RuntimeException('mandatory property >>subject<< not provided');
        }
    }
}
