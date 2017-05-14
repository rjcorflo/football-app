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

        try {
            $this->playerRepository->store($player);
        } catch (\Exception $e) {
            $message->isError();
            $message->setDescription("Error al almacenar el jugador");
            $message->addMessage($e->getMessage());
        }

        $message->setDescription("Registro correcto");

        $response->getBody()->write($this->resourceGenerator->createMessageResource($message));
    }

    public function login(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $aaa = $request->getServerParams();
        print_r($aaa);
        $response->getBody()->write('Hola');
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
