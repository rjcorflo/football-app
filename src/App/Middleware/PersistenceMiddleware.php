<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\FootballApp\Persistence\AbstractPersistenceLayer;

class PersistenceMiddleware
{
    private $persistenceLayer;

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
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable  $next)
    {
        $this->persistenceLayer->initialize();
        $next($request, $response);
        $this->persistenceLayer->finalize();
    }
}
