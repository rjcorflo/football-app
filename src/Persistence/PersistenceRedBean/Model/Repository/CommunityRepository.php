<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;

/**
 * Class CommunityRepository
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 */
class CommunityRepository extends AbstractRepository implements CommunityRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function checkIfNameExists(string $name) : bool
    {
        return R::count(static::ENTITY, 'name LIKE LOWER(?)', [$name]) > 0;
    }

    /**
     * @inheritDoc
     */
    public function findByName(string $name): CommunityInterface
    {
        /** @var SimpleModel $community */
        $community = R::findOne(static::ENTITY, 'name LIKE LOWER(?)', [$name]);

        return $community->box();
    }
}
