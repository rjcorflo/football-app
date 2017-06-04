<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ParticipantInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Repository for {@link ParticipantInterface} entities.
 *
 * @method ParticipantInterface create()
 * @method int store(ParticipantInterface $participant)
 * @method int[] storeMultiple(array $participants)
 * @method void trash(ParticipantInterface $participant)
 * @method void trashMultiple(array $participants)
 * @method ParticipantInterface getById(int $idParticipant)
 * @method ParticipantInterface[] getMultipleById(array $idsParticipants)
 * @method ParticipantInterface[] findAll()
 */
interface ParticipantRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'participant';

    /**
     * List community's players.
     * @param CommunityInterface $community
     * @return PlayerInterface[]
     */
    public function findPlayersFromCommunity(CommunityInterface $community): array;

    /**
     * List player's communities.
     * @param PlayerInterface $player
     * @return CommunityInterface[]
     */
    public function findCommunitiesFromPlayer(PlayerInterface $player): array;

    /**
     * Find participation from player in community.
     * @param PlayerInterface $player
     * @param CommunityInterface $community
     * @return mixed
     */
    public function findByPlayerAndCommunity(
        PlayerInterface $player,
        CommunityInterface $community
    ): ParticipantInterface;

    /**
     * Check if player is already a participant of the community.
     * @param PlayerInterface $player
     * @param CommunityInterface $community
     * @return bool
     */
    public function checkIfPlayerIsAlreadyFromCommunity(
        PlayerInterface $player,
        CommunityInterface $community
    ): bool;
}
