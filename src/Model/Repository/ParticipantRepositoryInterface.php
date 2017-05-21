<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

interface ParticipantRepositoryInterface
{
    /**
     * List players from community.
     * @param CommunityInterface $community
     * @return PlayerInterface[]
     */
    public function findPlayersFromCommunity(CommunityInterface $community
    ) : array;

    /**
     * List player's communities.
     * @param PlayerInterface $player
     * @return CommunityInterface[]
     */
    public function findCommunitiesFromPlayer(PlayerInterface $player) : array;
}
