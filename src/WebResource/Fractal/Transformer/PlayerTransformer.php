<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

class PlayerTransformer extends TransformerAbstract
{
    public function transform(PlayerInterface $player)
    {
        $item = [
            'nickname' => $player->getNickname(),
            'email' => $player->getEmail(),
            'fechaCreacion' => $player->getCreationDate()->format(\DateTime::ATOM),
            'nombre' => $player->getFirstName(),
            'apellidos' => $player->getLastName(),
            'comunidades' => $this->collection($player->getPlayerCommunities(), new CommunityTransformer())
        ];

        return $item;
    }
}
