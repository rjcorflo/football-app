<?php

namespace RJ\PronosticApp\App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Exception\Request\MissingParametersException;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Util\General\ErrorCodes;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\Util\Validation\Exception\ValidationException;

/**
 * Class CommunityController.
 *
 * Operations over communities.
 *
 * @package RJ\PronosticApp\Controller
 */
class CommunityController extends BaseController
{
    /**
     * Create community method.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function create(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $bodyData = $request->getParsedBody();

        /** @var PlayerInterface $player */
        $player = $request->getAttribute('player');

        try {
            // Retrieve data
            $name = $bodyData['nombre'] ?? '';
            $private = $bodyData['privada'] ?? 0;
            $password = $bodyData['password'] ?? '';
            $idImage = $bodyData['id_imagen'] ?? 1;

            if (!$name) {
                $exception = new MissingParametersException();
                $exception->addMessageWithCode(
                    ErrorCodes::MISSING_PARAMETERS,
                    'El parámetro ["nombre"] es obligatorio'
                );

                throw $exception;
            }

            /** @var CommunityRepositoryInterface $communityRepository */
            $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

            /** @var CommunityInterface $community */
            $community = $communityRepository->create();
            $community->setCommunityName($name);
            $community->setPrivate((bool)$private);
            $community->setPassword($password);
            $community->setCreationDate(new \DateTime());

            $this->validator->communityValidator()->validateCommunityData($community)->validate();

            $this->validator->existenceValidator()->checkIfNameExists($community)->validate();

            $this->validator->basicValidator()->validateId($idImage)->validate();

            /** @var ImageRepositoryInterface $imageRepository */
            $imageRepository = $this->entityManager->getRepository(ImageRepositoryInterface::class);

            /** @var ImageInterface $image */
            $image = $imageRepository->getById($idImage);

            // If image is not find, set standard image
            if ($image->getId() === 0) {
                $image = $imageRepository->getById(1);
                $community->setImage($image);
            } else {
                $community->setImage($image);
            }

            $community->addAdmin($player);

            // Prepare to store community
            $this->entityManager->transaction(function () use ($community, $player, $communityRepository) {
                $communityRepository->store($community);

                // Add player that create community as first participant
                /** @var ParticipantRepositoryInterface $participantRepo */
                $participantRepo = $this->entityManager->getRepository(ParticipantRepositoryInterface::class);
                $participant = $participantRepo->create();

                $participant->setCommunity($community);
                $participant->setPlayer($player);
                $participant->setCreationDate(new \DateTime());

                $participantRepo->store($participant);
            });

            $resource = $this->resourceGenerator->createCommunityResource($community);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }

    /**
     * Get players from community.
     *
     * @param ResponseInterface $response
     * @param int $idCommunity
     * @return ResponseInterface
     */
    public function communityPlayers(
        ResponseInterface $response,
        $idCommunity
    ) {
        /** @var CommunityRepositoryInterface $communityRepository */
        $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

        try {
            /** @var CommunityInterface $community */
            $community = $communityRepository->getById($idCommunity);

            $players = $community->getPlayers();

            $resource = $this->resourceGenerator->exclude('comunidades.jugadores')->createPlayerResource($players);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }

    /**
     * Check existence of community name.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function exist(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $bodyData = $request->getParsedBody();

        $result = new MessageResult();

        try {
            if (!isset($bodyData['nombre'])) {
                $exception = new MissingParametersException();
                $exception->addMessageWithCode(
                    ErrorCodes::MISSING_PARAMETERS,
                    'El parámetro ["nombre"] es obligatorio'
                );

                throw $exception;
            }

            $communityName = $bodyData['nombre'];

            /** @var CommunityRepositoryInterface $communityRepository */
            $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

            $nameExists = $communityRepository->checkIfNameExists($communityName);

            if ($nameExists) {
                $exception = new ValidationException('El registro ya existe');
                $exception->addMessageWithCode(
                    ErrorCodes::COMMUNITY_NAME_ALREADY_EXISTS,
                    'El nombre de la comunidad ya existe'
                );

                throw $exception;
            }

            $result->setDescription('Ese nombre de la comunidad está disponible');

            $resource = $this->resourceGenerator->createMessageResource($result);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }

    /**
     * Get data from community.
     *
     * @param ResponseInterface $response
     * @param int $idCommunity
     * @return ResponseInterface
     */
    public function communityData(
        ResponseInterface $response,
        $idCommunity
    ) {
        /** @var CommunityRepositoryInterface $communityRepository */
        $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

        try {
            /** @var CommunityInterface $community */
            $community = $communityRepository->getById($idCommunity);

            $resource = $this->resourceGenerator->createCommunityDataResource($community);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }
}
