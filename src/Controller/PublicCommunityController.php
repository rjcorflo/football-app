<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Exception\Request\MissingParametersException;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Util\General\ErrorCodes;
use RJ\PronosticApp\Util\General\MessageResult;

/**
 * Class PublicCommunityController.
 *
 * Expose public community data.
 *
 * @package RJ\PronosticApp\Controller
 */
class PublicCommunityController extends BaseController
{
    /**
     * List all public communities.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function list(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        /** @var CommunityRepositoryInterface $communityRepository */
        $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

        try {
            /** @var PlayerInterface $player */
            $player = $request->getAttribute('player');

            $communities = $communityRepository->getAllPublicCommunities($player);

            $resource = $this->resourceGenerator->createPublicCommunityResource($communities);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }

    /**
     * Join to public community.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function join(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $bodyData = $request->getParsedBody();

        $result = new MessageResult();

        try {
            $aleatorio = $bodyData['aleatorio'] ?? true;
            $idComunidad = $bodyData['id_comunidad'] ?? 0;

            if (!$aleatorio) {
                if ((int)$idComunidad < 1) {
                    $exception = new MissingParametersException();
                    $exception->addMessageWithCode(
                        ErrorCodes::MISSING_PARAMETERS,
                        'Si el parámetro ["aleatorio"] es false, el parámetro ["id_comunidad"] es obligatorio'
                    );

                    throw $exception;
                }
            }

            /** @var PlayerInterface $player */
            $player = $request->getAttribute('player');

            /** @var CommunityRepositoryInterface $communityRepository */
            $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

            if ($aleatorio) {
                $community = $communityRepository->getRandomCommunity($player);
            } else {
                $community = $communityRepository->getById($idComunidad);
            }

            // Check player is not already member of community
            $this->validator
                ->existenceValidator()
                ->checkIfPlayerIsAlreadyFromCommunity($player, $community)
                ->validate();

            /** @var ParticipantRepositoryInterface $participantRepo */
            $participantRepo = $this->entityManager->getRepository(ParticipantRepositoryInterface::class);

            $participant = $participantRepo->create();
            $participant->setPlayer($player);
            $participant->setCommunity($community);
            $participant->setCreationDate(new \DateTime());

            $participantRepo->store($participant);

            $result->setDescription(
                sprintf(
                    'El jugador %s se ha unido correctamente a la comunidad pública %s',
                    $player->getNickname(),
                    $community->getCommunityName()
                )
            );

            $resource = $this->resourceGenerator->createMessageResource($result);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }
}
