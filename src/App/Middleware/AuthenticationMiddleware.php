<?php

namespace RJ\PronosticApp\App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;

class AuthenticationMiddleware
{
    /**
     * @var PlayerRepositoryInterface
     */
    private $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * Middleware check user authentication.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $body = $request->getParsedBody();

        if (!$request->hasHeader('X-Auth-Token')) {
            $response = $response->withStatus(401, "Error autenticacion");
            return $response;
        }

        try {
            $token = $request->getHeader('X-Auth-Token');
            $player = $this->playerRepository->findPlayerByToken($token[0]);
            $request = $request->withAttribute('player', $player);
        } catch (\Exception $e) {
            $response = $response->withStatus(401, "Error autenticacion");
            return $response;
        }

        $response = $next($request, $response);
        return $response;
    }
}