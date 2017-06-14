<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\WebResource\Fractal\Resource\CommunityListResource;

/**
 * Class CommunityListTransformer.
 *
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class CommunityListTransformer extends TransformerAbstract
{
    /**
     * List of default resources for including.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'comunidades'
    ];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * PlayerTransformer constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param  CommunityListResource $communityList
     * @return array
     */
    public function transform(CommunityListResource $communityList)
    {
        $item = [
            'fecha_actual' => $communityList->getActualDate()->format('Y-m-d H:i:s')
        ];

        return $item;
    }

    /**
     * Include Comunidades.
     *
     * @param CommunityListResource $communityList
     * @return \League\Fractal\Resource\Collection
     */
    public function includeComunidades(CommunityListResource $communityList)
    {
        return $this->collection($communityList->getCommunities(), $this->container->get(CommunityTransformer::class));
    }
}
