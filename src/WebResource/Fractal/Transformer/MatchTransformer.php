<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;

/**
 * Class MatchTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class MatchTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'equipo_local',
        'equipo_visitante'
    ];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * TokenTransformer constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param MatchInterface $match
     * @return array
     */
    public function transform(MatchInterface $match)
    {
        $resource = [
            'id_partido' => $match->getId(),
            'id_jornada' => $match->getMatchday()->getId(),
            'id_competicion' => $match->getMatchday()->getCompetition()->getId(),
            'fecha' => strftime('%A, %d de %B de %Y', $match->getStartTime()->getTimestamp()),
            'hora' => $match->getStartTime()->format('H:i'),
            'tag' => $match->getTag(),
            'lugar' => $match->getStadium(),
            'url' => $match->getImage()->getUrl(),
            'estado' => $match->getState()
        ];

        $resource['goles_local'] = $match->getState() === MatchInterface::STATE_NOT_PLAYED ?
            -1 : $match->getLocalGoals();
        $resource['goles_visitante'] = $match->getState() === MatchInterface::STATE_NOT_PLAYED ?
            -1 : $match->getAwayGoals();

        return $resource;
    }

    /**
     * Include local team.
     *
     * @param MatchInterface $match
     * @return \League\Fractal\Resource\Item
     */
    public function includeEquipoLocal(MatchInterface $match)
    {
        return $this->item($match->getLocalTeam(), $this->container->get(TeamTransformer::class));
    }

    /**
     * Include local team.
     *
     * @param MatchInterface $match
     * @return \League\Fractal\Resource\Item
     */
    public function includeEquipoVisitante(MatchInterface $match)
    {
        return $this->item($match->getAwayTeam(), $this->container->get(TeamTransformer::class));
    }
}
