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
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        try {
            if (!$request->hasHeader('X-Auth-Token')) {
                throw new \Exception("No se ha pasado el token");
            }

            $token = $request->getHeader('X-Auth-Token');

            if (count($token) !== 1) {
                throw new \Exception("No existe el token o se han pasado varios.");
            }

            // Find player or launch excepction if not find one for token
            $player = $this->playerRepository->findPlayerByToken($token[0]);
            // Add player to request
            $request = $request->withAttribute('player', $player);
        } catch (\Exception $e) {
            $response = $response->withStatus(401, "Error autenticacion");
            return $response;
        }

        $response = $next($request, $response);
        return $response;
    }
}