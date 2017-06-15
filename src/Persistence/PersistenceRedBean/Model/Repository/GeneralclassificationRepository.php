<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\GeneralclassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\GeneralclassificationRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Generalclassification;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

/**
 * Class GeneralclassificationRepository.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 */
class GeneralclassificationRepository extends AbstractRepository implements GeneralclassificationRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findOneOrCreate(
        PlayerInterface $player,
        CommunityInterface $community,
        MatchdayInterface $matchday
    ): GeneralclassificationInterface {
        /** @var Generalclassification $bean */
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
                'community_id = ? AND matchday_id <= ? AND last_modified_date > ?',
                [$community->getId(), $nextMatchday->getId(), $date->format('Y-m-d H:i:s')]
            );
        } else {
            $matches = R::find(
                static::ENTITY,
                'community_id = ? AND matchday_id <= ?',
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
                ORDER BY total_points DESC, 
                         hits_ten_points DESC,
                         hits_five_points DESC,
                         hits_three_points DESC,
                         hits_two_points DESC,
                         hits_one_points DESC',
            [$matchday->getId(), $community->getId()]
        );

        return RedBeanUtils::boxArray($classifications);
    }
}
