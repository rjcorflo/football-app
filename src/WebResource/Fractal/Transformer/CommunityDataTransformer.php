<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Repository\MatchdayRepositoryInterface;
use RJ\PronosticApp\WebResource\Fractal\Resource\CommunityDataResource;

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

    /** @var MatchdayRepositoryInterface */
    private $matchdayRepository;

    /**
     * CommunityTransformer constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->matchdayRepository = $this->container->get(MatchdayRepositoryInterface::class);
    }

    /**
     * @param CommunityDataResource $dataResource
     * @return array
     */
    public function transform(CommunityDataResource $dataResource)
    {
        $resource = [
            'fecha_actual' => $dataResource->getDate()->format('Y-m-d H:i:s')
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
     * @param CommunityDataResource $dataResource
     * @return \League\Fractal\Resource\Collection
     */
    public function includeParticipantes(CommunityDataResource $dataResource)
    {
        return $this->collection($dataResource->getPlayers(), $this->container->get(PlayerTransformer::class));
    }

    /**
     * @param CommunityDataResource $dataResource
     * @return \League\Fractal\Resource\Collection
     */
    public function includeJornadas(CommunityDataResource $dataResource)
    {
        return $this->collection($dataResource->getMatchdays(), $this->container->get(MatchdayTransformer::class));
    }

    /**
     * @param CommunityDataResource $dataResource
     * @return \League\Fractal\Resource\Collection
     */
    public function includePartidos(CommunityDataResource $dataResource)
    {
        return $this->collection($dataResource->getMatches(), $this->container->get(MatchTransformer::class));
    }

    /**
     * @param CommunityDataResource $dataResource
     * @return \League\Fractal\Resource\Collection
     */
    public function includePronosticos(CommunityDataResource $dataResource)
    {
        return $this->collection($dataResource->getForecasts(), $this->container->get(ForecastTransformer::class));
    }

    /**
     * @param CommunityDataResource $dataResource
     * @return \League\Fractal\Resource\Collection
     */
    public function includeClasificacion(CommunityDataResource $dataResource)
    {
        return $this->collection(
            $dataResource->getClassification(),
            $this->container->get(MatchdayClassificationTransformer::class)
        );
    }
}
