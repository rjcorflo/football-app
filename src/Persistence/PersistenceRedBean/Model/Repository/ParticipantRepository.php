<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Community;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Player;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

class ParticipantRepository implements ParticipantRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findPlayersFromCommunity(CommunityInterface $community) : array
    {
        if (!$community instanceof Community) {
            throw new \Exception("Object must be an instance of Community");
        }

        $players = $community->unbox()->via(self::ENTITY)->sharedPlayerList;

        return RedBeanUtils::boxArray($players);
    }

    /**
     * @inheritDoc
     */
    public function findCommunitiesFromPlayer(PlayerInterface $player) : array
    {
        if (!$player instanceof Player) {
            throw new \Exception("Object must be an instance of Player");
        }

        $communities = $player->unbox()->via(self::ENTITY)->sharedCommunityList;

        return RedBeanUtils::boxArray($communities);
    }
}
