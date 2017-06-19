<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Repository\GeneralclassificationRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchdayclassificationRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository\MatchdayclassificationRepository;

/**
 * Class CommunityTransformer.
 *
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class CommunityTransformer extends TransformerAbstract
{
    /**
     * List of available resources for including.
     *
     * @var array
     */
    protected $availableIncludes = [
        'jugadores'
    ];

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ParticipantRepositoryInterface
     */
    private $participantRepo;

    /**
     * @var MatchdayclassificationRepositoryInterface
     */
    private $matchdayClassRepo;

    /**
     * @var GeneralclassificationRepositoryInterface
     */
    private $generalClassRepo;

    /**
     * CommunityTransformer constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->participantRepo = $this->container->get(ParticipantRepositoryInterface::class);
        $this->matchdayClassRepo = $this->container->get(MatchdayclassificationRepositoryInterface::class);
        $this->generalClassRepo = $this->container->get(GeneralclassificationRepositoryInterface::class);
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
            'password' => $community->getPassword(),
            'privada' => $community->isPrivate(),
            'id_imagen' => $community->getImage()->getId(),
            'url' => $community->getImage()->getUrl(),
            'fecha_creacion' => $community->getCreationDate()->format('d-m-Y'),
            'numero_jugadores' => $this->participantRepo->countPlayersFromCommunity($community),
            'puntos_ultima_jornada' => 0,
            'puesto_ultima_jornada' => 0,
            'puesto_general' => 0
        ];
    }

    /**
     * Include Players.
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
