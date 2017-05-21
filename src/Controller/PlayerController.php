<?php
namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Persistence;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

class PlayerController
{
    /**
     * @var PlayerRepositoryInterface
     */
    private $playerRepository;

    /**
     * @var WebResourceGeneratorInterface
     */
    private $resourceGenerator;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        PlayerRepositoryInterface $playerRepository,
        WebResourceGeneratorInterface $resourceGenerator,
        ValidatorInterface $validator
    ) {
        $this->playerRepository = $playerRepository;
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

            if (!$nickname || !$email || !$password) {
                throw new \Exception("Los campos nickname, email y password son necesarios para poder registrarse");
            }

            // Initialize Player data
            $player = $this->playerRepository->create();
            $player->setNickname($nickname);
            $player->setEmail($email);
            $player->setPassword($password);
            $player->setFirstName($firstName);
            $player->setLastName($lastName);
            $player->setCreationDate(new \DateTime());

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

            try {
                $this->playerRepository->store($player);
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

            // Retrieve player
            $players = $this->playerRepository->findPlayerByNicknameOrEmail($player);

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
            $token = $this->playerRepository->generateTokenForPlayer($player);

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
