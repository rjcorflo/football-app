<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\MatchdayclassificationInterface;

/**
 * Class MatchdayClassificationTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class MatchdayClassificationTransformer extends TransformerAbstract
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
     * @param MatchdayclassificationInterface $classification
     * @return array
     */
    public function transform(MatchdayclassificationInterface $classification)
    {
        return [
            'id_jornada' => $classification->getMatchday()->getId(),
            'id_comunidad' => $classification->getCommunity()->getId(),
            'id_jugador' => $classification->getPlayer()->getId(),
            'puesto' => $classification->getPosition(),
            'total' => $classification->getTotalPoints(),
            'aciertos_diez' => $classification->getHitsTenPoints(),
            'aciertos_cinco' => $classification->getHitsFivePoints(),
            'aciertos_tres' => $classification->getHitsThreePoints(),
            'aciertos_dos' => $classification->getHitsTwoPoints(),
            'aciertos_uno' => $classification->getHitsOnePoints(),
            'aciertos_negativo' => $classification->getHitsNegativePoints(),
            'puntos_posicion' => $classification->getPointsForPosition()
        ];
    }
}
