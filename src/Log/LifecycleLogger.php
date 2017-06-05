<?php

namespace RJ\PronosticApp\Log;

use Psr\Log\LoggerInterface;
use RJ\PronosticApp\Event\AppInitEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class LifecycleLogger.
 *
 * Log information for each request.
 *
 * @package RJ\PronosticApp\Log
 */
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
     * Log entries.
     */
    public function logEntry(AppInitEvent $event)
    {
        $this->logger->info('New entry.', $event->getRequest()->getServerParams());
    }
}
