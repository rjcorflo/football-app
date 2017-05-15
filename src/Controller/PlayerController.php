<?php
namespace RJ\PronosticApp\Controller;

use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Model\Validator\PlayerValidator;
use RJ\PronosticApp\Persistence;
use RJ\PronosticApp\Util\MessageResult;
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

    public function __construct(PlayerRepositoryInterface $playerRepository, WebResourceGeneratorInterface $resourceGenerator)
    {
        $this->playerRepository = $playerRepository;
        $this->resourceGenerator = $resourceGenerator;
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

        // Prepare new response
        $newResponse = $response->withHeader("Content-Type", "application/json");

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
            $result = (new PlayerValidator($player))->validate();

            if ($result->hasError()) {
                throw new \Exception("Error validando los datos del jugador.");
            }

            // Controller action
            $existsNickname = $this->playerRepository->checkNickameExists($player->getNickname());
            $existsEmail = $this->playerRepository->checkEmailExists($player->getEmail());

            if ($existsNickname || $existsEmail) {
                if ($existsNickname) {
                    $result->addMessage("Ya existe un usuario con ese nickname.");
                }

                if ($existsEmail) {
                    $result->addMessage("Ya existe un usuario con ese email.");
                }

                throw new \Exception("Ya existe un usuario con ese nickname o email.");
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

        $newResponse->getBody()->write($this->resourceGenerator->createMessageResource($result));
        return $newResponse;
    }

    public function login(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $bodyData = $request->getParsedBody();

        // Prepare new response
        $newResponse = $response->withHeader("Content-Type", "application/json");

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

            // Response
            $return = [
                'nickname' => $player->getNickname(),
                'email' => $player->getEmail(),
                'creation_date' => $player->getCreationDate()->format('d-m-Y H:i:s'),
                'token' => $token->getToken()
            ];
            $newResponse->getBody()->write(json_encode($return));
            return $newResponse;
        } catch (\Exception $e) {
            $result->isError();
            $result->setDescription($e->getMessage());
        }

        $newResponse->getBody()->write($this->resourceGenerator->createMessageResource($result));
        return $newResponse;
    }

    public function logout(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        // Prepare response
        $newResponse = $response->withHeader("Content-Type", "application/json");

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

        $newResponse->getBody()->write($this->resourceGenerator->createMessageResource($message));
        return $newResponse;
    }

    public function info(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        // Prepare response
        $newResponse = $response->withHeader("Content-Type", "application/json");

        /**
         * @var PlayerInterface $player
         */
        $player = $request->getAttribute('player');

        $string = [
            'nickname' => $player->getNickname(),
            'email' => $player->getEmail(),
            'nombre' => $player->getFirstName(),
            'apellidos' => $player->getLastName(),
            'comunidades' => $player->getPlayerCommunities()
        ];

        $newResponse->getBody()->write(json_encode($string));
        return $newResponse;
    }
}
