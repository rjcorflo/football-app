<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ParticipantInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\Exception\NotFoundException;

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
     * @param \DateTime|null $date
     * @return PlayerInterface[]
     */
    public function findPlayersFromCommunity(CommunityInterface $community, \DateTime $date = null): array;

    /**
     * List player's communities.
     *
     * Return player's communities. If a date is passed, return only communities in which the player has joined
     * after that date.
     *
     * @param PlayerInterface $player
     * @param \DateTime|null $date
     * @return CommunityInterface[]
     */
    public function findCommunitiesFromPlayer(PlayerInterface $player, \DateTime $date = null): array;

    /**
     * Find participation from player in community.
     * @param PlayerInterface $player
     * @param CommunityInterface $community
     * @return mixed
     * @throws NotFoundException
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

    /**
     * Return number of players from community.
     * @param CommunityInterface $community
     * @return int
     */
    public function countPlayersFromCommunity(CommunityInterface $community): int;

    /**
     * Return number of communities in which player participate.
     * @param PlayerInterface $player
     * @return int
     */
    public function countCommunitiesFromPlayer(PlayerInterface $player): int;
}
