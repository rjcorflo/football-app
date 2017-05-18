<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use RJ\PronosticApp\Model\Entity\CommunityInterface;

class CommunityTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'jugadores'
    ];

    public function transform(CommunityInterface $community)
    {
        return [
            'id' => $community->getId(),
            'nombre' => $community->getCommunityName(),
            'privada' => $community->isPrivate()
        ];
    }

    /**
     * Include Player
     *
     * @param CommunityInterface $community
     * @return \League\Fractal\Resource\Collection
     */
    public function includeJugadores(CommunityInterface $community)
    {
        $players = $community->getPlayers();

        return $this->collection($players, new PlayerTransformer());
    }
}
