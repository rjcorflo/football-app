<?php

namespace RJ\PronosticApp\App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Exception\Request\MissingParametersException;
use RJ\PronosticApp\Model\Repository\MatchRepositoryInterface;
use RJ\PronosticApp\Util\General\ErrorCodes;

/**
 * Class MatchController.
 *
 * @package RJ\PronosticApp\App\Controller
 */
class MatchController extends BaseController
{
    public function activeMatches(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) : ResponseInterface {
        $bodyData = $request->getParsedBody();

        try {
            if (!isset($bodyData['id_jornada'])) {
                $exception = new MissingParametersException();
                $exception->addMessageWithCode(
                    ErrorCodes::MISSING_PARAMETERS,
                    'El parámetro ["id_jornada"] es obligatorio'
                );

                throw $exception;
            }

            $idMatchday = $bodyData['id_jornada'];

            /** @var MatchRepositoryInterface $matchRepository */
            $matchRepository = $this->entityManager->getRepository(MatchRepositoryInterface::class);

            $matches = $matchRepository->findActivesByMatchday((int) $idMatchday);

            $resource = $this->resourceGenerator->createActiveMatchesResource($matches);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }
}
