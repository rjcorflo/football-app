<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\GeneralclassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayclassificationInterface;

/**
 * Class GeneralClassificationTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class GeneralClassificationTransformer extends TransformerAbstract
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
     * @param GeneralclassificationInterface $classification
     * @return array
     */
    public function transform(GeneralclassificationInterface $classification)
    {
        return [
            'id_jugador' => $classification->getPlayer()->getId(),
            'puesto' => $classification->getPosition(),
            'total' => $classification->getTotalPoints(),
            'aciertos_diez' => $classification->getHitsTenPoints(),
            'aciertos_cinco' => $classification->getHitsFivePoints(),
            'aciertos_tres' => $classification->getHitsThreePoints(),
            'aciertos_dos' => $classification->getHitsTwoPoints(),
            'aciertos_uno' => $classification->getHitsOnePoints(),
            'negativos' => $classification->getHitsNegativePoints(),
            'primero' => $classification->getTimesFirst(),
            'segundo' => $classification->getTimesSecond(),
            'tercero' => $classification->getTimesThird()
        ];
    }
}
