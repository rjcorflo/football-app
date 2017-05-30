<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Repository\StandardRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

abstract class AbstractRepository implements StandardRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function create()
    {
        /**
         * @var SimpleModel $bean
         */
        $bean = R::dispense(static::ENTITY);

        // Box to return correct type for type hinting
        return $bean->box();
    }

    /**
     * @inheritdoc
     */
    public function store($entity) : int
    {
        return R::store($entity);
    }

    /**
     * @inheritdoc
     */
    public function storeMultiple(array $entities) : array
    {
        return R::storeAll($entities);
    }

    /**
     * @inheritdoc
     */
    public function trash($entity) : void
    {
        R::trash($entity);
    }

    /**
     * @inheritdoc
     */
    public function trashMultiple(array $entities) : void
    {
        R::trashAll($entities);
    }

    /**
     * @inheritdoc
     */
    public function getById(int $idEntity)
    {
        /**
         * @var SimpleModel $bean
         */
        $bean = R::load(static::ENTITY, $idEntity);

        // Box to return correct type for type hinting
        return $bean->box();
    }

    /**
     * @inheritdoc
     */
    public function getMultipleById(array $entitiesIds) : array
    {
        $beans = R::loadAll(static::ENTITY, $entitiesIds);
        return RedBeanUtils::boxArray($beans);
    }

    /**
     * @inheritdoc
     */
    public function findAll() : array
    {
        $beans = R::findAll(static::ENTITY);
        return RedBeanUtils::boxArray($beans);
    }
}
