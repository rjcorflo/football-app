<?php

namespace RJ\PronosticApp\Log;

use Psr\Log\LoggerInterface;
use RJ\PronosticApp\Event\AppInitEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LifecycleLogger implements EventSubscriberInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * LifecycleLogger constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            AppInitEvent::NAME => [
                'logEntry'
            ]
        ];
    }

    /**
     * Log entry.
     */
    public function logEntry()
    {
        $this->logger->info('New entry.');
    }
}
