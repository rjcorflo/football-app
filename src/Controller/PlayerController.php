<?php
namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Persistence;
use RJ\PronosticApp\Util\MessageResult;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;
use RJ\PronosticApp\Aspect\Annotation\Logger;

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
     * @Logger
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function register(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $bodyData = $request->getParsedBody();

        $player = $this->playerRepository->create();
        $player->setNickname($bodyData['nickname']);
        $player->setEmail($bodyData['email']);
        $player->setPassword($bodyData['password']);

        $message = new MessageResult();

        if ($this->playerRepository->checkNickameExists($player->getNickname())) {
            $message->isError();
            $message->addMessage("Ya existe un usuario con ese nickname.");
        }

        if ($this->playerRepository->checkEmailExists($player->getEmail())) {
            $message->isError();
            $message->addMessage("Ya existe un usuario con ese email.");
        }

        if (!$message->hasError()) {
            try {
                $this->playerRepository->store($player);
                $message->setDescription("Registro correcto");
            } catch (\Exception $e) {
                $message->isError();
                $message->setDescription("Error al almacenar el jugador");
                $message->addMessage($e->getMessage());
            }
        }

        $newResponse = $response->withHeader("Content-Type", "application/json");
        $newResponse->getBody()->write($this->resourceGenerator->createMessageResource($message));
        return $newResponse;
    }

    public function login(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $bodyData = $request->getParsedBody();

        $players = $this->playerRepository->findPlayerByNicknameOrEmail($bodyData['player']);

        $message = new MessageResult();

        try {
            if (count($players) !== 1) {
                $message->isError();
                throw new \Exception("Login incorrecto");
            }

            $player = $players[0];
            if (password_verify($bodyData['password'], $player->getPassword())) {
                $message->isError();
                throw new \Exception("Login incorrecto");
            }

            $token = $player->generateToken();

        } catch (\Exception $e) {
            $message->setDescription($e->getMessage());
        }

        $newResponse = $response->withHeader("Content-Type", "application/json");
        $newResponse->getBody()->write($this->resourceGenerator->createMessageResource($message));
        return $newResponse;
    }

    public function logout(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $ide
    ) {
        $aaa = $request->getServerParams();
        print_r($aaa);
        $response->getBody()->write("Hola $ide");
    }

    public function getAll(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $players = $this->playerRepository->findAll();

        $salida = "";
        foreach ($players as $player) {
            $salida .= $player->getNickname() . ", " . $player->getEmail() . "; ";
        }

        $response->getBody()->write($salida);
    }
}
