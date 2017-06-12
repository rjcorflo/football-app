<?php

namespace RJ\PronosticApp\App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Util\General\ErrorCodes;
use RJ\PronosticApp\Util\Validation\Exception\ValidationException;

/**
 * Class PlayerController.
 *
 * Expose player data.
 *
 * @package RJ\PronosticApp\Controller
 */
class PlayerController extends BaseController
{
    /**
     * Get info about player.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function info(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        /**
         * @var PlayerInterface $player
         */
        $player = $request->getAttribute('player');

        $resource = $this->resourceGenerator->createPlayerResource($player);

        return $this->generateJsonCorrectResponse($response, $resource);
    }

    /**
     * List player communities.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function listPlayerCommunities(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $bodyData = $request->getParsedBody();
        /**
         * @var PlayerInterface $player
         */
        $player = $request->getAttribute('player');

        try {
            /** @var ParticipantRepositoryInterface $participantRepo */
            $participantRepo = $this->entityManager->getRepository(ParticipantRepositoryInterface::class);

            $date = null;

            if (isset($bodyData['fecha']) && $bodyData['fecha'] != '') {
                $date = \DateTime::createFromFormat('Y-m-d H:i:s', $bodyData['fecha']);

                if (!$date) {
                    $exception = new ValidationException('Error validando la fecha');
                    $exception->addMessageWithCode(
                        ErrorCodes::INCORRECT_DATE,
                        'Error parseando el campo fecha recibido. Debe venir en formato dd-MM-yyyy.'
                    );
                    throw $exception;
                }
            }

            $communitiesList = $participantRepo->findCommunitiesFromPlayer($player, $date);

            $resource = $this->resourceGenerator->createCommunityListResource($communitiesList);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }
}
