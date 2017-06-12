<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use RJ\PronosticApp\Model\Entity\TeamInterface;

/**
 * Class TeamTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class TeamTransformer extends TransformerAbstract
{
    /**
     * @param TeamInterface $team
     * @return array
     */
    public function transform(TeamInterface $team)
    {
        return [
            'id_equipo' => $team->getId(),
            'nombre' => $team->getName(),
            'nombre_abrev' => $team->getAlias(),
            'color_equipo' => $team->getColor(),
            'estadio' => $team->getStadium(),
            'ciudad' => 'PENDIENTE',
            'url' => $team->getImage()->getUrl()
        ];
    }
}
