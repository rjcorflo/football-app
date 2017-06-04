<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\TokenInterface;

/**
 * Class TokenTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class TokenTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'jugador'
    ];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * TokenTransformer constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param TokenInterface $token
     * @return array
     */
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
    public function includeJugador(TokenInterface $token)
    {
        $player = $token->getPlayer();

        return $this->item($player, $this->container->get(PlayerTransformer::class));
    }
}
