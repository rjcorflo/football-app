<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use RJ\PronosticApp\Model\Entity\TokenInterface;

class TokenTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'player'
    ];

    public function transform(TokenInterface $token)
    {
        return [
            'token' => $token->getToken()
        ];
    }

    /**
     * Include Player
     *
     * @param TokenInterface $token
     * @return \League\Fractal\Resource\Item
     */
    public function includePlayer(TokenInterface $token)
    {
        $player = $token->getPlayer();

        return $this->item($player, new PlayerTransformer);
    }
}
