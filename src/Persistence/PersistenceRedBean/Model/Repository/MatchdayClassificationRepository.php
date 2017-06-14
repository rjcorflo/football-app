<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\MatchdayClassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\MatchdayClassificationRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\MatchdayClassification;

/**
 * Class MatchdayClassificationRepository.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 */
class MatchdayClassificationRepository extends AbstractRepository implements MatchdayClassificationRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findOneOrCreate(
        PlayerInterface $player,
        CommunityInterface $community,
        MatchdayInterface $matchday
    ): MatchdayClassificationInterface {
        /** @var MatchdayClassification $bean */
        $bean = R::findOneOrDispense(
            static::ENTITY,
            'player_id = ? AND community_id = ? AND matchday_id = ?',
            [$player->getId(), $community->getId(), $matchday->getId()]
        );

        return $bean->box();
    }
}
