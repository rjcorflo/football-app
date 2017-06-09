<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\TokenInterface;

/**
 * Class MatchdayTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class MatchdayTransformer extends TransformerAbstract
{
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
     * @param MatchdayInterface $matchday
     * @return array
     */
    public function transform(MatchdayInterface $matchday)
    {
        return [
            'id_jornada' => $matchday->getId(),
            'id_competicion' => $matchday->getCompetition()->getId(),
            'competicion' => $matchday->getCompetition()->getName(),
            'competicion_abrev' => $matchday->getCompetition()->getAlias(),
            'fase' => $matchday->getPhase()->getName(),
            'fase_abrev' => 'XX',
            'nombre' => $matchday->getName(),
            'nombre_abrev' => $matchday->getAlias(),
            'factor' => $matchday->getPhase()->getMultiplierFactor(),
            'orden' => 1
        ];
    }
}
