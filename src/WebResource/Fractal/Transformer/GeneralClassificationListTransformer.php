<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\MatchdayclassificationInterface;
use RJ\PronosticApp\Model\Repository\MatchdayRepositoryInterface;
use RJ\PronosticApp\WebResource\Fractal\Resource\GeneralClassificationResource;

/**
 * Class GeneralClassificationListTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class GeneralClassificationListTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'clasificacion_general'
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
     * @param GeneralClassificationResource $data
     * @return array
     */
    public function transform(GeneralClassificationResource $data)
    {
        $repository = $this->container->get(MatchdayRepositoryInterface::class);
        return [
            'id_comunidad' => $data->getCommunity()->getId(),
            'fecha_actual' => $data->getDate()->format('Y-m-d H:i:s'),
            'id_jornada_actual' => $repository->getNextMatchday()->getId()
        ];
    }

    /**
     * Include general classification.
     *
     * @param GeneralClassificationResource $data
     * @return \League\Fractal\Resource\Collection
     */
    public function includeClasificacionGeneral(GeneralClassificationResource $data)
    {
        return $this->collection(
            $data->getGeneralMatchdayClassification(),
            $this->container->get(GeneralMatchdayTransformer::class)
        );
    }
}
