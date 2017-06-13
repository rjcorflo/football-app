<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
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
    public function findAllOrdered(): array
    {
        $beans = R::findAll(static::ENTITY, 'ORDER BY matchday_order ASC');

        return RedBeanUtils::boxArray($beans);
    }
}
