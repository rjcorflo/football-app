<?php
namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Model\Repository\TokenRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Util\General\ErrorCodes;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

/**
 * Class PlayerController.
 * Expose player data.
 * @package RJ\PronosticApp\Controller
 */
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

    /**
     * PlayerController constructor.
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
            /** @var PlayerInterface $player */
            $player = $playerRepository->create();
            $player->setNickname($nickname);
            $player->setEmail($email);
            $player->setPassword($password);
            $player->setFirstName($firstName);
            $player->setLastName($lastName);
            $player->setCreationDate(new \DateTime());
            $player->setIdAvatar($idAvatar);
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

            try {
                $playerRepository->store($player);
                $result->setDescription("Registro correcto");
            } catch (\Exception $e) {
                $result->addDefaultMessage($e->getMessage());
                throw new \Exception("Error al almacenar el jugador");
            }
        } catch (\Exception $e) {
            $result->isError();
            $result->setDescription($e->getMessage());
        }

        $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
        return $response;
    }

    /**
     * Check existence of player via mail or username.
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

        // Prepare result
        $result = new MessageResult();

        try {
            // Retrieve data
            if (!isset($bodyData['nickname']) && !isset($bodyData['email'])) {
                $result->isError();
                $result->setDescription('El parametro nickname o email son necesarios');
                $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
                $response = $response->withStatus(400, 'Parameter needed');
                return $response;
            }

            $nickname = $bodyData['nickname'] ?? '';
            $email = $bodyData['email'] ?? '';

            /** @var PlayerRepositoryInterface $playerRepository */
            $playerRepository = $this->entityManager->getRepository(PlayerRepositoryInterface::class);

            if ($nickname != '' && $playerRepository->checkNickameExists($nickname)) {
                $result->isError();
                $result->addMessageWithCode(
                    ErrorCodes::EXIST_PLAYER_USERNAME,
                    'El nombre de usuario ya existe'
                );
            }

            if ($email != '' && $playerRepository->checkEmailExists($email)) {
                $result->isError();
                $result->addMessageWithCode(
                    ErrorCodes::EXIST_PLAYER_EMAIL,
                    'El email ya existe'
                );
            }

            if ($result->hasError()) {
                throw new \Exception('Nombre de usuario o email existentes');
            }

            $result->setDescription('Datos disponibles');
        } catch (\Exception $e) {
            $result->setDescription($e->getMessage());
        }

        $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
        return $response;
    }

    /**
     * Login for user.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
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

            /** @var PlayerRepositoryInterface $playerRepository */
            $playerRepository = $this->entityManager->getRepository(PlayerRepositoryInterface::class);

            // Retrieve player
            $players = $playerRepository->findPlayerByNicknameOrEmail($player);

            if (count($players) !== 1) {
                $result->addMessageWithCode(
                    ErrorCodes::LOGIN_ERROR_INCORRECT_USERNAME,
                    "Nombre o email incorrectos"
                );
                throw new \Exception("Login incorrecto");
            }

            $player = array_shift($players);

            if (!password_verify($bodyData['password'], $player->getPassword())) {
                $result->addMessageWithCode(
                    ErrorCodes::LOGIN_ERROR_INCORRECT_PASSWORD,
                    "Password incorrecta"
                );
                throw new \Exception("Login incorrecto");
            }

            // Correct login

            /** @var TokenRepositoryInterface $tokenRepository */
            $tokenRepository = $this->entityManager->getRepository(TokenRepositoryInterface::class);

            // Generate token
            $token = $tokenRepository->createRandomToken();
            $player->addToken($token);

            $playerRepository->store($player);

            $response->getBody()->write($this->resourceGenerator->createTokenResource($token));
            return $response;
        } catch (\Exception $e) {
            $result->isError();
            $result->setDescription($e->getMessage());
        }

        $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
        return $response;
    }

    /**
     * Logout for user.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
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

            /** @var TokenRepositoryInterface $tokenRepository */
            $tokenRepository = $this->entityManager->getRepository(TokenRepositoryInterface::class);
            $token = $tokenRepository->findByTokenString($tokenString[0]);

            $player->removeToken($token);

            /** @var PlayerRepositoryInterface $playerRepository */
            $playerRepository = $this->entityManager->getRepository(PlayerRepositoryInterface::class);

            $playerRepository->store($player);
            $message->setDescription(sprintf("Jugador %s ha hecho logout correctamente", $player->getNickname()));
        } catch (\Exception $e) {
            $message->isError();
            $message->setDescription(sprintf("Jugador %s ha hecho logout correctamente", $player->getNickname()));
        }

        $response->getBody()->write($this->resourceGenerator->createMessageResource($message));
        return $response;
    }

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
