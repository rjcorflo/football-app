<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\Exception\NotFoundException;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

/**
 * Class PublicCommunityController.
 *
 * Expose public community data.
 *
 * @package RJ\PronosticApp\Controller
 */
class PublicCommunityController
{
    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * @var WebResourceGeneratorInterface
     */
    private $resourceGenerator;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * CommunityController constructor.
     * @param EntityManager $entityManager
     * @param WebResourceGeneratorInterface $resourceGenerator
     * @param ValidatorInterface $validator
     */
    public function __construct(
        EntityManager $entityManager,
        WebResourceGeneratorInterface $resourceGenerator,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->resourceGenerator = $resourceGenerator;
        $this->validator = $validator;
    }

    /**
     * List all public communities.
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function list(
        ResponseInterface $response
    ) {
        /** @var CommunityRepositoryInterface $communityRepository */
        $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

        $communities = $communityRepository->getAllPublicCommunities();

        $response->getBody()->write($this->resourceGenerator->createPublicCommunityResource($communities));
        return $response;
    }

    /**
     * Join to private community.
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function join(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $bodyData = $request->getParsedBody();

        $result = new MessageResult();

        try {
            $aleatorio = $bodyData['aleatorio'] ?? true;
            $idComunidad = $bodyData['id_comunidad'] ?? 0;

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
            $result = $this->validator->existenceValidator()
                ->checkIfPlayerIsAlreadyFromCommunity($player, $community)->validate();

            if ($result->hasError()) {
                throw new \Exception('El jugador ya es miembro de la comunidad');
            }

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
        } catch (NotFoundException $nfe) {
            $result = $nfe->convertToMessageResult();
            $result->setDescription('Error recuperando la comunidad a la que desea unirse');
        } catch (\Exception $e) {
            $result->isError();
            $result->setDescription($e->getMessage());
        }

        $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
        return $response;
    }
}
