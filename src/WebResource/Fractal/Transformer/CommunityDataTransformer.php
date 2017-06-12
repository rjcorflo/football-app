<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Repository\MatchdayRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;

/**
 * Class CommunityDataTransformer.
 *
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class CommunityDataTransformer extends TransformerAbstract
{
    /**
     * List of available resources for including.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'participantes',
        'jornadas'
    ];

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ParticipantRepositoryInterface
     */
    private $participantRepo;

    /** @var MatchdayRepositoryInterface  */
    private $matchdayRepository;

    /**
     * CommunityTransformer constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->participantRepo = $this->container->get(ParticipantRepositoryInterface::class);
        $this->matchdayRepository = $this->container->get(MatchdayRepositoryInterface::class);
    }

    /**
     * @param CommunityInterface $community
     * @return array
     */
    public function transform(CommunityInterface $community)
    {
        return [
            'partidos' => [],
            'pronosticos' => []
        ];
    }

    /**
     * Include Players.
     *
     * @param CommunityInterface $community
     * @return \League\Fractal\Resource\Collection
     */
    public function includeParticipantes(CommunityInterface $community)
    {
        $players = $community->getPlayers();

        return $this->collection($players, $this->container->get(PlayerTransformer::class));
    }

    /**
     * @param CommunityInterface $community
     * @return \League\Fractal\Resource\Collection
     */
    public function includeJornadas(CommunityInterface $community)
    {
        $matchdays = $this->matchdayRepository->findAll();

        return $this->collection($matchdays, $this->container->get(MatchdayTransformer::class));
    }
}
