<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\CommunityInterface;

/**
 * Class CommunityTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
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

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * CommunityTransformer constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param CommunityInterface $community
     * @return array
     */
    public function transform(CommunityInterface $community)
    {
        return [
            'id' => $community->getId(),
            'nombre' => $community->getCommunityName(),
            'privada' => $community->isPrivate(),
            'url' => $community->getImage()->getUrl()
        ];
    }

    /**
     * Include Players
     *
     * @param CommunityInterface $community
     * @return \League\Fractal\Resource\Collection
     */
    public function includeJugadores(CommunityInterface $community)
    {
        $players = $community->getPlayers();

        return $this->collection($players, $this->container->get(PlayerTransformer::class));
    }
}
