<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Repository\MatchRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

/**
 * Class MatchRepository.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 */
class MatchRepository extends AbstractRepository implements MatchRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findActivesByMatchday(int $idMatchday): array
    {
        $actualDate = new \DateTime();

        $beans = R::find(
            static::ENTITY,
            'matchday_id = ? AND start_time > ?',
            [$idMatchday, $actualDate->format('Y-m-d H:i:s')]
        );

        return RedBeanUtils::boxArray($beans);
    }
}
