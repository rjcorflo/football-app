<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Community;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

class CommunityRepository implements CommunityRepositoryInterface
{
    const BEAN_NAME = 'community';

    /**
     * @inheritDoc
     */
    public function create() : CommunityInterface
    {
        /**
         * @var Community $bean
         */
        $bean = R::dispense(self::BEAN_NAME);

        // Box to return correct type for type hinting
        return $bean->box();
    }

    /**
     * @inheritDoc
     */
    public function store(CommunityInterface $community) : int
    {
        if (!$community instanceof Community) {
            throw new \Exception("Object must be an instance of Community");
        }

        return R::store($community);
    }

    /**
     * @inheritDoc
     */
    public function storeMultiple(array $entities) : array
    {
        return R::storeAll($entities);
    }

    /**
     * @inheritDoc
     */
    public function trash(CommunityInterface $community) : void
    {
        if (!$community instanceof Community) {
            throw new \Exception("Object must be an instance of Player");
        }

        R::trash($community);
    }

    /**
     * @inheritDoc
     */
    public function trashMultiple(array $entities) : void
    {
        R::trashAll($entities);
    }

    /**
     * @inheritDoc
     */
    public function getById(int $communityId) : CommunityInterface
    {
        /**
         * @var Community $bean
         */
        $bean = R::load(self::BEAN_NAME, $communityId);

        // Box to return correct type for type hinting
        return $bean->box();
    }

    /**
     * @inheritDoc
     */
    public function getMultipleById(array $communitiesIds) : array
    {
        $beans = R::loadAll(self::BEAN_NAME, $communitiesIds);

        return RedBeanUtils::boxArray($beans);
    }

    /**
     * @inheritDoc
     */
    public function findAll() : array
    {
        $communities = R::findAll(self::BEAN_NAME);

        return RedBeanUtils::boxArray($communities);
    }

    /**
     * @inheritDoc
     */
    public function checkIfNameExists(string $name) : bool
    {
        return R::count(self::BEAN_NAME, 'name LIKE LOWER(?)', [$name]) > 0;
    }
}
