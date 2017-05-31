<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\ImageInterface;

class ImageTransformer extends TransformerAbstract
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function transform(ImageInterface $image)
    {
        return [
            'id' => $image->getId(),
            'url' => $image->getUrl()
        ];
    }
}
