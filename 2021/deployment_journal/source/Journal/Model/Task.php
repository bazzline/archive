<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2017-12-09
 */

namespace Net\Bazzline\DeploymentJournal\Journal\Model;

use Net\Bazzline\DeploymentJournal\Journal\Service\TaskHandler\TaskHandlerInterface;

class Task
{
    /** @var string */
    private $content;

    /** @var string*/
    private $description;

    /** @var TaskHandlerInterface */
    private $handler;

    /**
     * Task constructor.
     *
     * @param string $content
     * @param string $description
     * @param TaskHandlerInterface $handler
     */
    public function __construct(
        string $content,
        string $description,
        TaskHandlerInterface $handler
    ) {
        $this->content      = $content;
        $this->description  = $description;
        $this->handler      = $handler;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function handler(): TaskHandlerInterface
    {
        return $this->handler;
    }

    public function execute()
    {
        $this->handler->handle(
            $this->content
        );
    }
}