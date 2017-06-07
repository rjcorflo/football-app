<?php

namespace RJ\PronosticApp\App\Event;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Event launch on request received.
 *
 * @package RJ\PronosticApp\Event
 */
class AppInitEvent extends Event
{
    const NAME = 'app.initialized';

    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * AppInitEvent constructor.
     *
     * @param ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
