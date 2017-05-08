<?php
namespace RJ\FootballApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\FootballApp\Aspect\Annotation\Logger;

class PlayerController
{
    /**
     * @Logger
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    public function register(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $response->getBody()->write('Hola');
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
}
