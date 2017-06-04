<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ParticipantInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\Exception\NotFoundException;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Community;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Player;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;
use RJ\PronosticApp\Util\General\ErrorCodes;

/**
 * Class ParticipantRepository
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 */
class ParticipantRepository extends AbstractRepository implements ParticipantRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findPlayersFromCommunity(CommunityInterface $community): array
    {
        if (!$community instanceof Community) {
            throw new \Exception("Object must be an instance of Community");
        }

        $players = $community->unbox()->via(static::ENTITY)->sharedPlayerList;

        return RedBeanUtils::boxArray($players);
    }

    /**
     * @inheritDoc
     */
    public function findCommunitiesFromPlayer(PlayerInterface $player): array
    {
        if (!$player instanceof Player) {
            throw new \Exception("Object must be an instance of Player");
        }

        $communities = $player->unbox()->via(static::ENTITY)->sharedCommunityList;

        return RedBeanUtils::boxArray($communities);
    }

    /**
     * @inheritDoc
     */
    public function findByPlayerAndCommunity(
        PlayerInterface $player,
        CommunityInterface $community
    ): ParticipantInterface {
        /** @var SimpleModel $participant */
        $participant = R::findOne(
            static::ENTITY,
            'community_id = ? AND player_id = ?',
            [$community->getId(), $player->getId()]
        );

        if ($participant === null) {
            $exception = new NotFoundException();
            $exception->addMessageWithCode(
                ErrorCodes::PLAYER_IS_NOT_MEMBER,
                sprintf(
                    'El jugador %s no es miembro de la comunidad %s',
                    $player->getNickname(),
                    $community->getCommunityName()
                )
            );

            throw $exception;
        }

        return $participant->box();
    }

    /**
     * @inheritDoc
     */
    public function checkIfPlayerIsAlreadyFromCommunity(
        PlayerInterface $player,
        CommunityInterface $community
    ): bool {
        $registers = R::count(
            static::ENTITY,
            'community_id = ? AND player_id = ?',
            [$community->getId(), $player->getId()]
        );

        return $registers > 0;
    }


}
