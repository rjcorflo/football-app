<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

interface ParticipantRepositoryInterface
{
    /**
     * Add a player to existing community.
     * @param \RJ\PronosticApp\Model\Entity\PlayerInterface $player
     * @param \RJ\PronosticApp\Model\Entity\CommunityInterface $community
     */
    public function addPlayerToCommunity(
        PlayerInterface $player,
        CommunityInterface $community
    ) : void;

    /**
     * Remove player from existing community.
     * @param \RJ\PronosticApp\Model\Entity\PlayerInterface $player
     * @param \RJ\PronosticApp\Model\Entity\CommunityInterface $community
     */
    public function removePlayerFromCommunity(
        PlayerInterface $player,
        CommunityInterface $community
    ) : void;

    /**
     * List players from community.
     * @param CommunityInterface $community
     * @return PlayerInterface[]
     */
    public function listPlayersFromCommunity(CommunityInterface $community
    ) : array;

    /**
     * List player's communities.
     * @param PlayerInterface $player
     * @return CommunityInterface[]
     */
    public function listCommunitiesFromPlayer(PlayerInterface $player) : array;
}
