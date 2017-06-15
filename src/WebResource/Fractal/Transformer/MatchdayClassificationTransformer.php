<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\MatchdayclassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\TokenInterface;

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
            'id_jugador' => $classification->getPlayer()->getId(),
            'puesto' => rand(1, 3),
            'total' => $classification->getTotalPoints(),
            'aciertos_diez' => $classification->getHitsTenPoints(),
            'aciertos_cinco' => $classification->getHitsFivePoints(),
            'aciertos_tres' => $classification->getHitsThreePoints(),
            'aciertos_dos' => $classification->getHitsTwoPoints(),
            'aciertos_uno' => $classification->getHitsOnePoints(),
            'aciertos_negativo' => $classification->getHitsNegativePoints(),
            'puntos_posicion' => 0
        ];
    }
}
