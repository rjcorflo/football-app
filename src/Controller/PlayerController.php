<?php
namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

class PlayerController
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
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function register(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $bodyData = $request->getParsedBody();

        // Prepare result
        $result = new MessageResult();

        try {
            // Retrieve data
            $nickname = $bodyData['nickname'] ?? '';
            $email = $bodyData['email'] ?? '';
            $password = $bodyData['password'] ?? '';
            $firstName = $bodyData['nombre'] ?? '';
            $lastName = $bodyData['apellidos'] ?? '';
            $idAvatar = $bodyData['id_avatar'] ?? 1;
            $color = $bodyData['color'] ?? '#FFFFFF';

            if (!$nickname || !$email || !$password) {
                throw new \Exception("Los campos nickname, email y password son necesarios para poder registrarse");
            }

            $playerRepository = $this->entityManager->getRepository(PlayerRepositoryInterface::class);

            // Initialize Player data
            $player = $playerRepository->create();
            $player->setNickname($nickname);
            $player->setEmail($email);
            $player->setPassword($password);
            $player->setFirstName($firstName);
            $player->setLastName($lastName);
            $player->setCreationDate(new \DateTime());
            $player->setColor($color);

            // Data validation
            $result = $this->validator
                ->playerValidator()
                ->validatePlayerData($player)
                ->validate();

            if ($result->hasError()) {
                throw new \Exception("Error validando los datos del jugador.");
            }

            $result = $this->validator
                ->existenceValidator()
                ->checkIfEmailExists($player)
                ->checkIfNicknameExists($player)
                ->validate();

            if ($result->hasError()) {
                throw new \Exception($result->getDescription());
            }

            $result = $this->validator
                ->basicValidator()
                ->validateId($idAvatar)
                ->validate();

            if ($result->hasError()) {
                throw new \Exception("Error validando los datos de la imagen.");
            }

            $imageRepository = $this->entityManager->getRepository(ImageRepositoryInterface::class);
            $image = $imageRepository->getById($idAvatar);

            if ($image->getId() === 0) {
                $image->setUrl('/images/1.jpg');
                $player->setImage($image);
            } else {
                $player->setImage($image);
            }

            try {
                $playerRepository->store($player);
                $result->setDescription("Registro correcto");
            } catch (\Exception $e) {
                $result->addMessage($e->getMessage());
                throw new \Exception("Error al almacenar el jugador");
            }
        } catch (\Exception $e) {
            $result->isError();
            $result->setDescription($e->getMessage());
        }

        $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
        return $response;
    }

    public function login(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $bodyData = $request->getParsedBody();

        // Prepare result
        $result = new MessageResult();

        try {
            // Retrieve data
            $player = $bodyData['player'] ?? '';
            $password = $bodyData['password'] ?? '';

            if (!$player || !$password) {
                throw new \Exception('Los campos player y password son necesarios para poder hacer login.');
            }

            $playerRepository = $this->entityManager->getRepository(PlayerRepositoryInterface::class);

            // Retrieve player
            $players = $playerRepository->findPlayerByNicknameOrEmail($player);

            if (count($players) !== 1) {
                $result->addMessage("Nombre, email o password incorrectos");
                throw new \Exception("Login incorrecto");
            }

            /**
             * @var PlayerInterface $player
             */
            $player = array_shift($players);

            if (!password_verify($bodyData['password'], $player->getPassword())) {
                $result->addMessage("Nombre, mail o password incorrectos");
                throw new \Exception("Login incorrecto");
            }

            // Correct login
            // Generate token
            $token = $playerRepository->generateTokenForPlayer($player);

            $response->getBody()->write($this->resourceGenerator->createTokenResource($token));
            return $response;
        } catch (\Exception $e) {
            $result->isError();
            $result->setDescription($e->getMessage());
        }

        $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
        return $response;
    }

    public function logout(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        /**
         * @var PlayerInterface $player
         */
        $player = $request->getAttribute('player');

        // Prepare result
        $message = new MessageResult();

        try {
            $tokenString = $request->getHeader('X-Auth-Token');
            $this->playerRepository->removePlayerToken($player, $tokenString[0]);
            $message->setDescription(sprintf("Jugador %s ha hecho logout correctamente", $player->getNickname()));
        } catch (\Exception $e) {
            $message->isError();
            $message->setDescription(sprintf("Jugador %s ha hecho logout correctamente", $player->getNickname()));
        }

        $response->getBody()->write($this->resourceGenerator->createMessageResource($message));
        return $response;
    }

    public function info(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        /**
         * @var PlayerInterface $player
         */
        $player = $request->getAttribute('player');

        $response->getBody()->write($this->resourceGenerator
            ->exclude('comunidades.jugadores')->createPlayerResource($player));
        return $response;
    }
}
