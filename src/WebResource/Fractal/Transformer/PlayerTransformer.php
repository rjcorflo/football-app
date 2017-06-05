<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Class PlayerTransformer.
 *
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class PlayerTransformer extends TransformerAbstract
{
    /**
     * List of available resources for including.
     *
     * @var array
     */
    protected $availableIncludes = [
        'comunidades'
    ];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * PlayerTransformer constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param PlayerInterface $player
     * @return array
     */
    public function transform(PlayerInterface $player)
    {
        $item = [
            'id' => $player->getId(),
            'nickname' => $player->getNickname(),
            'email' => $player->getEmail(),
            'nombre' => $player->getFirstName(),
            'apellidos' => $player->getLastName(),
            'icon' => $player->getIdAvatar(),
            'color' => $player->getColor()
        ];

        return $item;
    }

    /**
     * Include Comunidades.
     *
     * @param PlayerInterface $player
     * @return \League\Fractal\Resource\Collection
     */
    public function includeComunidades(PlayerInterface $player)
    {
        $communities = $player->getPlayerCommunities();

        return $this->collection($communities, $this->container->get(CommunityTransformer::class));
    }
}
