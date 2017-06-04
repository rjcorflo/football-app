<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\Util\General\ResponseGenerator;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

/**
 * Class CommunityController
 *
 * Operations over communities.
 *
 * @package RJ\PronosticApp\Controller
 */
class CommunityController
{
    use ResponseGenerator;

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
     * Create community method.
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

        // Prepare result
        $result = new MessageResult();

        try {
            // Retrieve data
            $name = $bodyData['nombre'] ?? '';
            $private = $bodyData['privada'] ?? 0;
            $password = $bodyData['password'] ?? '';
            $idImage = $bodyData['id_imagen'] ?? 1;

            if (!$name) {
                $response = $this->generateParameterNeededResponse(
                    $response,
                    'El parámetro "nombre" es obligatorio para crear una comunidad'
                );

                return $response;
            }

            /** @var CommunityRepositoryInterface $communityRepository */
            $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

            /** @var CommunityInterface $community */
            $community = $communityRepository->create();
            $community->setCommunityName($name);
            $community->setPrivate((bool)$private);
            $community->setPassword($password);
            $community->setCreationDate(new \DateTime());

            $result = $this->validator->communityValidator()->validateCommunityData($community)->validate();

            if ($result->hasError()) {
                throw new \Exception("Error validando los datos de la comunidad.");
            }

            $result = $this->validator->existenceValidator()->checkIfNameExists($community)->validate();

            if ($result->hasError()) {
                throw new \Exception("Ya existe una comunidad con ese nombre.");
            }

            $result = $this->validator->basicValidator()->validateId($idImage)->validate();

            if ($result->hasError()) {
                throw new \Exception("Error validando los datos de la imagen.");
            }

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
                // Hash password before creation
                $hash = password_hash($community->getPassword(), PASSWORD_BCRYPT);
                $community->setPassword($hash);
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

            $response->getBody()
                ->write($this->resourceGenerator->createCommunityResource($community));
            return $response;
        } catch (\Exception $e) {
            $result->isError();
            $result->setDescription($e->getMessage());
        }

        $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
        return $response;
    }

    /**
     * Get players from community.
     *
     * @param ResponseInterface $response
     * @param $idCommunity
     * @return ResponseInterface
     */
    public function communityPlayers(
        ResponseInterface $response,
        $idCommunity
    ) {
        /** @var CommunityRepositoryInterface $communityRepository */
        $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

        /** @var CommunityInterface $community */
        $community = $communityRepository->getById($idCommunity);

        $players = $community->getPlayers();

        $response->getBody()
            ->write($this->resourceGenerator->exclude('comunidades.jugadores')->createPlayerResource($players));
        return $response;
    }

    public function search(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $parameters = $request->getQueryParams();

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

        if (!isset($bodyData['nombre'])) {
            $response = $this->generateParameterNeededResponse(
                $response,
                'El parámetro "nombre" es obligatorio para crear una comunidad'
            );

            return $response;
        }

        /** @var CommunityRepositoryInterface $communityRepository */
        $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

        $nameExists = $communityRepository->checkIfNameExists($bodyData['nombre']);

        if ($nameExists) {
            $result->isError();
            $result->setDescription('Ya existe una comunidad con ese nombre');
        } else {
            $result->setDescription('Ese nombre de comunidad está disponible');
        }

        $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
        return $response;
    }
}
