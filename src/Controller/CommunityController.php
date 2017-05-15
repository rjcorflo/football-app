<?php
namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

class CommunityController
{
    public function create(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        /**
         * @var PlayerInterface $player
         */
        $player = $request->getAttribute('player');


    }
}
