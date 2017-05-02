<?php
namespace RJ\FootballApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController
{
    public function login(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $name
    ) {
    }

    public function logout(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $id
    ) {
    }
}
