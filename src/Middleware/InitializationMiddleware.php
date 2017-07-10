<?php

namespace RJ\PronosticApp\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\App\Event\AppInitEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class InitializationMiddleware.
 *
 * Launch initialization and finished events.
 *
 * @package RJ\PronosticApp\App\Middleware
 */
class InitializationMiddleware
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * InitializationMiddleware constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Middleware to init and free resources from persistence layer if necessary.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $this->dispatcher->dispatch(AppInitEvent::NAME, new AppInitEvent($request));
        /**
         * @var ResponseInterface $response
         */
        $response = $next($request, $response);

        return $response;
    }
}
