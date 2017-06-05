<?php

namespace RJ\PronosticApp\Event;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Initialization event.
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
