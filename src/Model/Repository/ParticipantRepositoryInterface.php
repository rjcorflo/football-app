<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

interface ParticipantRepositoryInterface
{
    public function addPlayerToCommunity(PlayerInterface $player, CommunityInterface $community) : void;

    public function removePlayerFromCommunity(PlayerInterface $player, CommunityInterface $community) : void;

    /**
     * @param CommunityInterface $community
     * @return PlayerInterface[]
     */
    public function listPlayersFromCommunity(CommunityInterface $community) : array;

    /**
     * @param PlayerInterface $player
     * @return CommunityInterface[]
     */
    public function listCommunitiesFromPlayer(PlayerInterface $player) : array;
}