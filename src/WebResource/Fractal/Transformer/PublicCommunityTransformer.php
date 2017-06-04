<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;

/**
 * Class CommunityTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class PublicCommunityTransformer extends CommunityTransformer
{
    /**
     * @var ParticipantRepositoryInterface
     */
    private $participantRepo;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->participantRepo = $this->container->get(ParticipantRepositoryInterface::class);
    }

    /**
     * @inheritDoc
     */
    public function transform(CommunityInterface $community)
    {
        $resource = parent::transform($community);
        unset($resource['privada']);
        $resource['fecha_creacion'] = $community->getCreationDate()->format(\DateTime::ATOM);
        $resource['numero_jugadores'] = $this->participantRepo->countPlayersFromCommunity($community);

        return $resource;
    }
}
