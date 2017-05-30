<?php

namespace RJ\PronosticApp\App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

/**
 * Authentication middleware.
 */
class AuthenticationMiddleware
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var WebResourceGeneratorInterface
     */
    private $webResourceGenerator;

    public function __construct(
        EntityManager $entityManager,
        WebResourceGeneratorInterface $webResourceGenerator
    ) {
        $this->entityManager = $entityManager;
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

            // Find player or launch exception if not find one for token
            /** @var PlayerRepositoryInterface $playerRepository */
            $playerRepository = $this->entityManager->getRepository(PlayerRepositoryInterface::class);
            $player = $playerRepository->findPlayerByToken($token[0]);

            // Add player to request
            $request = $request->withAttribute('player', $player);
        } catch (\Exception $e) {
            $result = new MessageResult();
            $result->isError();
            $result->setDescription("No puede acceder a este recurso sin estar logueado");

            $errorResponse = $response->withHeader('Content-type', 'application/json');
            $errorResponse = $errorResponse->withStatus(401, "Error autenticacion");
            $errorResponse->getBody()->write($this->webResourceGenerator->createMessageResource($result));

            return $response;
        }

        $response = $next($request, $response);
        return $response;
    }
}
