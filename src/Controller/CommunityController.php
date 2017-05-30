<?php
namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

class CommunityController
{
    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * @var ImageRepositoryInterface
     */
    private $imageRepository;

    /**
     * @var WebResourceGeneratorInterface
     */
    private $resourceGenerator;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        EntityManager $entityManager,
        WebResourceGeneratorInterface $resourceGenerator,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->resourceGenerator = $resourceGenerator;
        $this->validator = $validator;
    }

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
            $color = $bodyData['color'] ?? '#FFFFFF';

            if (!$name) {
                throw new \Exception("El campo nombre es obligatorio para crear una comunidad");
            }

            /** @var CommunityRepositoryInterface $communityRepository */
            $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

            /** @var CommunityInterface $community */
            $community = $communityRepository->create();
            $community->setCommunityName($name);
            $community->setPrivate((bool)$private);
            $community->setPassword($password);
            $community->setColor($color);

            $result = $this->validator
                ->communityValidator()
                ->validateCommunityData($community)
                ->validate();

            if ($result->hasError()) {
                throw new \Exception("Error validando los datos de la comunidad.");
            }

            $result = $this->validator
                ->basicValidator()
                ->validateId($idImage)
                ->validate();

            if ($result->hasError()) {
                throw new \Exception("Error validando los datos de la imagen.");
            }

            /** @var ImageRepositoryInterface $imageRepository */
            $imageRepository = $this->entityManager->getRepository(ImageRepositoryInterface::class);

            /** @var ImageInterface $image */
            $image = $imageRepository->getById($idImage);

            if ($image->getId() === 0) {
                $image->setUrl('/images/1.jpg');
                $community->setImage($image);
            } else {
                $community->setImage($image);
            }

            $result = $this->validator
                ->existenceValidator()
                ->checkIfNameExists($community)
                ->validate();

            if ($result->hasError()) {
                throw new \Exception("Ya existe una comunidad con ese nombre.");
            }

            $community->addAdmin($player);

            $communityRepository->store($community);

            $response->getBody()
                ->write($this->resourceGenerator->exclude('jugadores')->createCommunityResource($community));
            return $response;
        } catch (\Exception $e) {
            $result->isError();
            $result->setDescription($e->getMessage());
        }

        $response->getBody()
            ->write($this->resourceGenerator->createMessageResource($result));
        return $response;
    }

    public function communityPlayers(
        ResponseInterface $response,
        $idCommunity
    ) {
        /**
         * @var PlayerInterface $player
         */
        //$player = $request->getAttribute('player');

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

    public function exist(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $bodyData = $request->getParsedBody();

        $result = new MessageResult();

        if (!isset($bodyData['nombre'])) {
            $result->isError();
            $result->setDescription('El parametro nombre es necesario');
            $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
            $response = $response->withStatus(400, 'Parameter needed');
            return $response;
        }

        $nameExists = $this->communityRepository->checkIfNameExists($bodyData['nombre']);

        if ($nameExists) {
            $result->isError();
            $result->setDescription('Ya existe una comunidad con ese nombre');
        } else {
            $result->setDescription('Ese nombre de comunidad está disponible');
        }

        return $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
    }
}
