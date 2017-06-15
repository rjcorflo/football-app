<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ForecastInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\ForecastRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Forecast;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

/**
 * Class ForecastRepository.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 */
class ForecastRepository extends AbstractRepository implements ForecastRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findOneOrCreate(
        PlayerInterface $player,
        CommunityInterface $community,
        MatchInterface $match
    ): ForecastInterface {
        /** @var Forecast $bean */
        $bean = R::findOneOrDispense(
            static::ENTITY,
            'player_id = ? AND community_id = ? AND match_id = ?',
            [$player->getId(), $community->getId(), $match->getId()]
        );

        return $bean->box();
    }

    /**
     * @inheritDoc
     */
    public function findAllFromCommunity(
        CommunityInterface $community,
        PlayerInterface $player,
        MatchdayInterface $matchday
    ): array {
        /** @var Forecast $bean */
        $beans = R::find(
            static::ENTITY,
            'player_id = ? AND community_id = ?',
            [$player->getId(), $community->getId()]
        );

        $result = [];
        foreach ($beans as $bean) {
            if ($bean->getMatch()->getMatchday()->getId() == $matchday->getId()) {
                $result[] = $bean;
            }
        }

        return RedBeanUtils::boxArray($result);
    }

    /**
     * @inheritDoc
     */
    public function findByCommunity(CommunityInterface $community, \DateTime $date = null): array
    {
        if ($date !== null) {
            $matches = R::find(
                static::ENTITY,
                'community_id = ? AND last_modified_date > ?',
                [$community->getId(), $date->format('Y-m-d H:i:s')]
            );
        } else {
            $matches = R::find(
                static::ENTITY,
                'community_id = ?',
                [$community->getId()]
            );
        }

        return RedBeanUtils::boxArray($matches);
    }
}
