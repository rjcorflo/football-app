<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\MatchdayclassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\MatchdayclassificationRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Matchdayclassification;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

/**
 * Class MatchdayclassificationRepository.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 */
class MatchdayclassificationRepository extends AbstractRepository implements MatchdayclassificationRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findOneOrCreate(
        PlayerInterface $player,
        CommunityInterface $community,
        MatchdayInterface $matchday
    ): MatchdayclassificationInterface {
        /** @var Matchdayclassification $bean */
        $bean = R::findOneOrDispense(
            static::ENTITY,
            'player_id = ? AND community_id = ? AND matchday_id = ?',
            [$player->getId(), $community->getId(), $matchday->getId()]
        );

        return $bean->box();
    }

    /**
     * @inheritDoc
     */
    public function findByCommunity(CommunityInterface $community): array
    {
        $beans = R::find(static::ENTITY, 'community_id = ?', [$community->getId()]);

        return RedBeanUtils::boxArray($beans);
    }

    /**
     * @inheritDoc
     */
    public function findByCommunityUntilNextMatchdayModifiedAfterDate(
        CommunityInterface $community,
        MatchdayInterface $nextMatchday,
        \DateTime $date = null
    ): array {
        if ($date !== null) {
            $matches = R::find(
                static::ENTITY,
                'community_id = ? AND matchday_id <= ? AND last_modified_date > ? ORDER BY position',
                [$community->getId(), $nextMatchday->getId(), $date->format('Y-m-d H:i:s')]
            );
        } else {
            $matches = R::find(
                static::ENTITY,
                'community_id = ? AND matchday_id <= ? ORDER BY position',
                [$community->getId(), $nextMatchday->getId()]
            );
        }

        return RedBeanUtils::boxArray($matches);
    }

    /**
     * @inheritDoc
     */
    public function findOrderedByMatchdayAndCommunity(
        MatchdayInterface $matchday,
        CommunityInterface $community
    ): array {
        $classifications = R::find(
            static::ENTITY,
            'matchday_id = ? AND community_id = ?
                ORDER BY basic_points DESC, 
                         hits_ten_points DESC,
                         hits_five_points DESC,
                         hits_three_points DESC,
                         hits_two_points DESC,
                         hits_one_points DESC,
                         hits_negative_points ASC',
            [$matchday->getId(), $community->getId()]
        );
        
        return RedBeanUtils::boxArray($classifications);
    }
}
