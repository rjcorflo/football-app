<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;
use RJ\PronosticApp\Model\Repository\MatchdayRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

/**
 * Class MatchdayRepository.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 */
class MatchdayRepository extends AbstractRepository implements MatchdayRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getNextMatchday(): ?MatchdayInterface
    {
        $actualDate = (new \DateTime())->format('Y-m-d H:i:s');

        $bean = R::findOne(MatchRepositoryInterface::ENTITY, 'start_time > ? ORDER BY start_time', [$actualDate]);

        if ($bean === null) {
            return $bean;
        }

        /** @var MatchInterface $match */
        $match = $bean->box();

        return $match->getMatchday();
    }

    /**
     * @inheritDoc
     */
    public function findAllUntilNextMatchday(): array
    {
        $nextMatchday = $this->getNextMatchday();

        $matchdays = R::find(static::ENTITY, 'id <= ?', [$nextMatchday->getId()]);

        return RedBeanUtils::boxArray($matchdays);
    }


    /**
     * @inheritDoc
     */
    public function findAllOrdered(): array
    {
        $beans = R::findAll(static::ENTITY, 'ORDER BY matchday_order ASC');

        return RedBeanUtils::boxArray($beans);
    }

    /**
     * @inheritDoc
     */
    public function findByCommunity(CommunityInterface $community, \DateTime $date = null): array
    {
        if ($date !== null) {
            $matchdays = R::find(
                static::ENTITY,
                'last_modified_date > ? ORDER BY matchday_order ASC',
                [$date->format('Y-m-d H:i:s')]
            );
        } else {
            $matchdays = R::findAll(static::ENTITY);
        }

        return RedBeanUtils::boxArray($matchdays);
    }
}
