<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository\ParticipantRepository;

class PlayerTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $availableIncludes = [
        'comunidades'
    ];

    /**
     * @var \RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface
     */
    private $participantRepo;

    public function __construct(ParticipantRepositoryInterface $participantRepo)
    {
        $this->participantRepo = $participantRepo;
    }

    public function transform(PlayerInterface $player)
    {
        $item = [
            'id' => $player->getId(),
            'nickname' => $player->getNickname(),
            'email' => $player->getEmail(),
            'nombre' => $player->getFirstName(),
            'apellidos' => $player->getLastName()
        ];

        return $item;
    }

    /**
     * Include Comunidades
     *
     * @param PlayerInterface $player
     * @return \League\Fractal\Resource\Collection
     */
    public function includeComunidades(PlayerInterface $player)
    {
        $communities = $this->participantRepository->findCommunitiesFromPlayer($player);

        return $this->collection($communities, new CommunityTransformer());
    }
}
