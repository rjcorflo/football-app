<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ForecastInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\ForecastRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Forecast;

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

}
