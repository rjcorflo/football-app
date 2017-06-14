<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Repository\ForecastRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchdayClassificationRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchdayRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchRepositoryInterface;
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
        'jornadas',
        'partidos',
        'pronosticos',
        'clasificacion'
    ];

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ParticipantRepositoryInterface
     */
    private $participantRepo;

    /** @var MatchdayRepositoryInterface */
    private $matchdayRepository;

    /** @var MatchRepositoryInterface */
    private $matchRepository;

    /** @var ForecastRepositoryInterface */
    private $forecastRepository;

    /** @var MatchdayClassificationRepositoryInterface */
    private $matchdayClassRepo;

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
        $this->matchRepository = $this->container->get(MatchRepositoryInterface::class);
        $this->forecastRepository = $this->container->get(ForecastRepositoryInterface::class);
        $this->matchdayClassRepo = $this->container->get(MatchdayClassificationRepositoryInterface::class);
    }

    /**
     * @param CommunityInterface $community
     * @return array
     */
    public function transform(CommunityInterface $community)
    {
        $resource = [
            'fecha_actual' => (new \DateTime())->format('Y-m-d H:i:s')
        ];

        $matchday = $this->matchdayRepository->getNextMatchday();

        if ($matchday === null) {
            $resource['id_jornada_actual'] = 0;
        } else {
            $resource['id_jornada_actual'] = $matchday->getId();
        }

        return $resource;
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
        $matchdays = $this->matchdayRepository->findAllOrdered();

        return $this->collection($matchdays, $this->container->get(MatchdayTransformer::class));
    }

    /**
     * @param CommunityInterface $community
     * @return \League\Fractal\Resource\Collection
     */
    public function includePartidos(CommunityInterface $community)
    {
        $matches = $this->matchRepository->findAll();

        return $this->collection($matches, $this->container->get(MatchTransformer::class));
    }

    /**
     * @param CommunityInterface $community
     * @return \League\Fractal\Resource\Collection
     */
    public function includePronosticos(CommunityInterface $community)
    {
        $forecasts = $this->forecastRepository->findByCommunity($community);

        return $this->collection($forecasts, $this->container->get(ForecastTransformer::class));
    }

    /**
     * @param CommunityInterface $community
     * @return \League\Fractal\Resource\Collection
     */
    public function includeClasificacion(CommunityInterface $community)
    {
        $classifications = $this->matchdayClassRepo->findByCommunity($community);

        return $this->collection($classifications, $this->container->get(MatchdayClassificationTransformer::class));
    }
}
