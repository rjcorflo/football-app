<?php
namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

class CommunityController
{
    /**
     * @var \RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface
     */
    private $communityRepository;

    /**
     * @var \RJ\PronosticApp\WebResource\WebResourceGeneratorInterface
     */
    private $resourceGenerator;

    /**
     * @var \RJ\PronosticApp\Util\Validation\ValidatorInterface
     */
    private $validator;

    public function __construct(
        CommunityRepositoryInterface $communityRepository,
        WebResourceGeneratorInterface $resourceGenerator,
        ValidatorInterface $validator
    ) {
        $this->communityRepository = $communityRepository;
        $this->resourceGenerator = $resourceGenerator;
        $this->validator = $validator;
    }

    public function create(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $bodyData = $request->getParsedBody();

        /**
         * @var PlayerInterface $player
         */
        $player = $request->getAttribute('player');

        // Prepare result
        $result = new MessageResult();

        try {
            // Retrieve data
            $name = $bodyData['nombre'] ?? '';
            $private = $bodyData['privada'] ?? 0;
            $password = $bodyData['password'] ?? '';


            if (!$name) {
                throw new \Exception("El campo nombre es obligatorio para crear una comunidad");
            }

            $community = $this->communityRepository->create();
            $community->setCommunityName($name);
            $community->setPrivate((bool)$private);
            $community->setPassword($password);

            $result = $this->validator
                ->communityValidator()
                ->validateCommunityData($community)
                ->validate();

            if ($result->hasError()) {
                throw new \Exception("Error validando los datos de la comunidad.");
            }

            $result = $this->validator
                ->existenceValidator()
                ->checkIfNameExists($community)
                ->validate();

            if ($result->hasError()) {
                throw new \Exception("Ya existe una comunidad con ese nombre.");
            }

            $community->addAdmin($player);

            $this->communityRepository->store($community);

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
        ServerRequestInterface $request,
        ResponseInterface $response,
        $idCommunity
    ) {
        /**
         * @var PlayerInterface $player
         */
        //$player = $request->getAttribute('player');

        $community =$this->communityRepository->getById($idCommunity);

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
        $parameters = $request->getQueryParams();

        $result = new MessageResult();

        if (!isset($parameters['nombre'])) {
            $result->isError();
            $result->setDescription('El parametro nombre es necesario');
            $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
            $response = $response->withStatus(400, 'Parameter needed');
            return $response;
        }

        $nameExists = $this->communityRepository->checkIfNameExists($parameters['nombre']);

        if ($nameExists) {
            $result->isError();
            $result->setDescription('Ya existe una comunidad con ese nombre');
        } else {
            $result->setDescription('Ese nombre de comunidad está disponible');
        }

        return $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
    }
}
