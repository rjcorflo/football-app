<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;

/**
 * Class CommunityRepository
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 * @method CommunityInterface create()
 * @method int store(CommunityInterface $community)
 * @method int[] storeMultiple(array $communities)
 * @method void trash(CommunityInterface $community)
 * @method void trashMultiple(array $communities)
 * @method CommunityInterface getById(int $idCommunity)
 * @method CommunityInterface getMultipleById(array $idsCommunities)
 * @method CommunityInterface[] findAll()
 */
class CommunityRepository extends AbstractRepository implements CommunityRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function checkIfNameExists(string $name) : bool
    {
        return R::count(self::ENTITY, 'name LIKE LOWER(?)', [$name]) > 0;
    }
}
