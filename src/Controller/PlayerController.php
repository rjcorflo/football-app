<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Exception\PasswordNotMatchException;
use RJ\PronosticApp\Model\Exception\Request\MissingParametersException;
use RJ\PronosticApp\Model\Repository\Exception\PersistenceException;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Model\Repository\TokenRepositoryInterface;
use RJ\PronosticApp\Util\General\ErrorCodes;
use RJ\PronosticApp\Util\General\MessageResult;
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
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function register(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
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
                $exception = new MissingParametersException();
                $exception->addMessageWithCode(
                    ErrorCodes::MISSING_PARAMETERS,
                    'Los parámetros ["nickname", "email", "password"] son obligatorios para registrarse'
                );

                throw $exception;
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
            $this->validator
                ->playerValidator()
                ->validatePlayerData($player)
                ->validate();

            // Validate existence
            $this->validator
                ->existenceValidator()
                ->checkIfEmailExists($player)
                ->checkIfNicknameExists($player)
                ->validate();

            $this->validator
                ->basicValidator()
                ->validateId($idAvatar)
                ->validate();

            try {
                $playerRepository->store($player);
                $result->setDescription("Registro correcto");
            } catch (\Exception $e) {
                $exception = new PersistenceException('Error al almacenar el jugador');
                $exception->addDefaultMessage($e->getMessage());
                throw $exception;
            }

            $resource = $this->resourceGenerator->createMessageResource($result);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

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
    ): ResponseInterface {
        $bodyData = $request->getParsedBody();

        // Prepare result
        $result = new MessageResult();

        try {
            // Retrieve data
            if (!isset($bodyData['nickname']) && !isset($bodyData['email'])) {
                $exception = new MissingParametersException();
                $exception->addMessageWithCode(
                    ErrorCodes::MISSING_PARAMETERS,
                    'Uno de los parámetros ["nickname", "email"] tiene que ser pasado para comprobar si existen'
                );

                throw $exception;
            }

            $nickname = $bodyData['nickname'] ?? '';
            $email = $bodyData['email'] ?? '';

            /** @var PlayerRepositoryInterface $playerRepository */
            $playerRepository = $this->entityManager->getRepository(PlayerRepositoryInterface::class);

            if ($nickname != '' && $playerRepository->checkNickameExists($nickname)) {
                $result->isError();
                $result->addMessageWithCode(
                    ErrorCodes::PLAYER_USERNAME_ALREADY_EXISTS,
                    'El nombre de usuario ya existe'
                );
            }

            if ($email != '' && $playerRepository->checkEmailExists($email)) {
                $result->isError();
                $result->addMessageWithCode(
                    ErrorCodes::PLAYER_EMAIL_ALREADY_EXISTS,
                    'El email ya existe'
                );
            }

            if ($result->hasError()) {
                $result->setDescription('Nombre de usuario o email existentes');

                $exception = ValidationException::createFromMessageResult($result);
                throw $exception;
            }

            $result->setDescription('Datos disponibles');

            $resource = $this->resourceGenerator->createMessageResource($result);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

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
    ): ResponseInterface {
        $bodyData = $request->getParsedBody();

        try {
            // Retrieve data
            $playerData = $bodyData['player'] ?? '';
            $password = $bodyData['password'] ?? '';

            if (!$playerData || !$password) {
                $exception = new MissingParametersException();
                $exception->addMessageWithCode(
                    ErrorCodes::MISSING_PARAMETERS,
                    'Los parámetros ["player", "password"] son obligatorios para poder loguearse'
                );

                throw $exception;
            }

            /** @var PlayerRepositoryInterface $playerRepository */
            $playerRepository = $this->entityManager->getRepository(PlayerRepositoryInterface::class);

            // Retrieve player
            $player = $playerRepository->findPlayerByNicknameOrEmail($playerData);

            if (!password_verify($bodyData['password'], $player->getPassword())) {
                $exception = new PasswordNotMatchException();
                $exception->addMessageWithCode(
                    ErrorCodes::INCORRECT_PASSWORD,
                    "Password incorrecta"
                );

                throw $exception;
            }

            // Correct login
            /** @var TokenRepositoryInterface $tokenRepository */
            $tokenRepository = $this->entityManager->getRepository(TokenRepositoryInterface::class);

            // Generate token
            $token = $tokenRepository->createRandomToken();
            $player->addToken($token);

            $playerRepository->store($player);

            $resource = $this->resourceGenerator->createTokenResource($token);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

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
    ): ResponseInterface {
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

            $resource = $this->resourceGenerator->createMessageResource($message);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $exception = new \Exception(
                sprintf(
                    "Jugador %s no ha podido hacer logout correctamente",
                    $player->getNickname()
                ),
                $e
            );

            $response = $this->generateJsonErrorResponse($response, $exception);
        }

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
    ): ResponseInterface {
        /**
         * @var PlayerInterface $player
         */
        $player = $request->getAttribute('player');

        $resource = $this->resourceGenerator
            ->exclude('comunidades.jugadores')->createPlayerResource($player);

        return $this->generateJsonCorrectResponse($response, $resource);
    }
}
