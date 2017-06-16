<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\MatchdayclassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Repository\GeneralclassificationRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchdayRepositoryInterface;
use RJ\PronosticApp\WebResource\Fractal\Resource\GeneralClassificationResource;
use RJ\PronosticApp\WebResource\Fractal\Resource\GeneralMatchdayClassificationResource;

/**
 * Class GeneralMatchdayTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class GeneralMatchdayTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'clasificacion'
    ];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var GeneralclassificationRepositoryInterface
     */
    private $generalClassRepo;

    /**
     * TokenTransformer constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->generalClassRepo = $this->container->get(GeneralclassificationRepositoryInterface::class);
    }

    /**
     * @param GeneralMatchdayClassificationResource $resource
     * @return array
     */
    public function transform(GeneralMatchdayClassificationResource $resource)
    {
        return [
            'id_jornada' => $resource->getMatchday()->getId()
        ];
    }

    /**
     * Include classification.
     *
     * @param GeneralMatchdayClassificationResource $resource
     * @return \League\Fractal\Resource\Collection
     */
    public function includeClasificacion(GeneralMatchdayClassificationResource $resource)
    {
        $classifications = $this->generalClassRepo->findOrderedByMatchdayAndCommunity(
            $resource->getMatchday(),
            $resource->getCommunity()
        );

        return $this->collection($classifications, $this->container->get(GeneralClassificationTransformer::class));
    }
}
