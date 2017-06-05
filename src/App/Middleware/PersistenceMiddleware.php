<?php

namespace RJ\PronosticApp\App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Persistence\AbstractPersistenceLayer;

/**
 * Class PersistenceMiddleware.
 *
 * Initialize persistence layer.
 *
 * @package RJ\PronosticApp\App\Middleware
 */
class PersistenceMiddleware
{
    /**
     * @var AbstractPersistenceLayer
     */
    private $persistenceLayer;

    /**
     * PersistenceMiddleware constructor.
     *
     * @param AbstractPersistenceLayer $persistenceLayer
     */
    public function __construct(AbstractPersistenceLayer $persistenceLayer)
    {
        $this->persistenceLayer = $persistenceLayer;
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
        $this->persistenceLayer->initialize();
        $response = $next($request, $response);
        $this->persistenceLayer->finalize();
        return $response;
    }
}
