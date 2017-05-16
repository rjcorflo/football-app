<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Community;
use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Player;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

class ParticipantRepository implements ParticipantRepositoryInterface
{
    const BEAN_NAME = 'participant';

    /**
     * @inheritdoc
     */
    public function addPlayerToCommunity(PlayerInterface $player, CommunityInterface $community) : void
    {
        if (!$player instanceof Player) {
            throw new \Exception("Object must be an instance of Player");
        } elseif (!$community instanceof Community) {
            throw new \Exception("Object must be an instance of Community");
        }

        $participant = R::dispense(self::BEAN_NAME);
        $participant->community = $community;
        $participant->player = $player;
        $participant->creationDate = new \DateTime();

        R::store($participant);
    }

    /**
     * @inheritdoc
     */
    public function removePlayerFromCommunity(PlayerInterface $player, CommunityInterface $community) : void
    {
        if (!$player instanceof Player) {
            throw new \Exception("Object must be an instance of Player");
        } elseif (!$community instanceof Community) {
            throw new \Exception("Object must be an instance of Community");
        }

        unset($community->unbox()->via(self::BEAN_NAME)->sharedPlayerList[$player->getId()]);

        R::store($community);
    }

    /**
     * @inheritDoc
     */
    public function listPlayersFromCommunity(CommunityInterface $community) : array
    {
        if (!$community instanceof Community) {
            throw new \Exception("Object must be an instance of Community");
        }

        $players = $community->unbox()->via(self::BEAN_NAME)->sharedPlayerList;

        return RedBeanUtils::boxArray($players);
    }

    /**
     * @inheritDoc
     */
    public function listCommunitiesFromPlayer(PlayerInterface $player) : array
    {
        if (!$player instanceof Player) {
            throw new \Exception("Object must be an instance of Player");
        }

        $communities = $player->unbox()->via(self::BEAN_NAME)->sharedCommunityList;

        return RedBeanUtils::boxArray($communities);
    }
}
