<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use RJ\PronosticApp\Model\Entity\ImageInterface;

/**
 * Class ImageTransformer.
 *
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class ImageTransformer extends TransformerAbstract
{
    /**
     * @param ImageInterface $image
     * @return array
     */
    public function transform(ImageInterface $image)
    {
        return [
            'id' => $image->getId(),
            'url' => $image->getUrl()
        ];
    }
}
