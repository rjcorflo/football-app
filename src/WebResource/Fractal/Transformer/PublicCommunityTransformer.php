<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\CommunityInterface;

/**
 * Class CommunityTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class PublicCommunityTransformer extends CommunityTransformer
{
    /**
     * @inheritDoc
     */
    public function transform(CommunityInterface $community)
    {
        $resource = parent::transform($community);
        unset($resource['privada']);

        return $resource;
    }
}
