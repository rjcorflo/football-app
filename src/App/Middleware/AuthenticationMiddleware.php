<?php

namespace RJ\PronosticApp\App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

class AuthenticationMiddleware
{
    /**
     * @var PlayerRepositoryInterface
     */
    private $playerRepository;

    /**
     * @var \RJ\PronosticApp\WebResource\WebResourceGeneratorInterface
     */
    private $webResourceGenerator;

    public function __construct(
        PlayerRepositoryInterface $playerRepository,
        WebResourceGeneratorInterface $webResourceGenerator
    ) {
        $this->playerRepository = $playerRepository;
        $this->webResourceGenerator = $webResourceGenerator;
    }

    /**
     * Middleware check user authentication.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ) {
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
            $result = new MessageResult();
            $result->isError();
            $result->setDescription("No puede acceder a este recurso sin estar logueado");

            $response = $response->withHeader('Content-type', 'application/json');
            $response = $response->withStatus(401, "Error autenticacion");
            $response->getBody()->write($this->webResourceGenerator->createMessageResource($result));
            return $response;
        }

        $response = $next($request, $response);
        return $response;
    }
}
