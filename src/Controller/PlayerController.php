<?php
namespace RJ\FootballApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\FootballApp\Aspect\Annotation\Logger;
use RJ\FootballApp\Model\Repository\PlayerRepositoryInterface;
use RJ\FootballApp\Persistence;

class PlayerController
{
    /**
     * @var PlayerRepositoryInterface
     */
    private $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
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
        $player->setPassword($bodyData['pass']);

        $this->playerRepository->store($player);

        $response->getBody()->write(print_r($bodyData, true));
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
