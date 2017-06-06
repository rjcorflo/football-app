<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;

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
    public function listCommunities(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        /**
         * @var PlayerInterface $player
         */
        $player = $request->getAttribute('player');

        try {
            /** @var ParticipantRepositoryInterface $participantRepo */
            $participantRepo = $this->entityManager->getRepository(ParticipantRepositoryInterface::class);

            $commutiesList = $participantRepo->findCommunitiesFromPlayer($player);

            $resource = $this->resourceGenerator->createCommunityResource($commutiesList);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }
}
