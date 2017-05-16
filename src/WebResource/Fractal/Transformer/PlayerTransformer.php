<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

class PlayerTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'comunidades'
    ];

    public function transform(PlayerInterface $player)
    {
        $item = [
            'id' => $player->getId(),
            'nickname' => $player->getNickname(),
            'email' => $player->getEmail(),
            'fechaCreacion' => $player->getCreationDate()->format(\DateTime::ATOM),
            'nombre' => $player->getFirstName(),
            'apellidos' => $player->getLastName()
        ];

        return $item;
    }

    /**
     * Include Player
     *
     * @param PlayerInterface $player
     * @return \League\Fractal\Resource\Collection
     */
    public function includeComunidades(PlayerInterface $player)
    {
        $communities = $player->getPlayerCommunities();

        return $this->collection($communities, new CommunityTransformer());
    }
}
