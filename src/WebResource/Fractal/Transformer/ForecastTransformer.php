<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\ForecastInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;

/**
 * Class ForecastTransformer
 *
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class ForecastTransformer extends TransformerAbstract
{
    /**
     * @param ForecastInterface $forecast
     * @return array
     */
    public function transform(ForecastInterface $forecast)
    {
        $resource = [
            'id_pronostico' => $forecast->getId(),
            'id_partido' => $forecast->getMatch()->getId(),
            'id_jornada' => $forecast->getMatch()->getMatchday()->getId(),
            'id_comunidad' => $forecast->getCommunity()->getId(),
            'riesgo' => $forecast->isRisk(),
            'puntos' => $forecast->getPoints()
        ];

        $resource['goles_local'] = $forecast->getMatch()->getState() === MatchInterface::STATE_NOT_PLAYED ?
            -1 : $forecast->getMatch()->getLocalGoals();
        $resource['goles_visitante'] = $forecast->getMatch()->getState() === MatchInterface::STATE_NOT_PLAYED ?
            -1 : $forecast->getMatch()->getAwayGoals();

        return $resource;
    }
}
