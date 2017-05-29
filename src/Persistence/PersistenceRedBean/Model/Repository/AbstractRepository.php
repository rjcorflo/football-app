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
        $bean = R::dispense(static::BEAN_NAME);

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
        $bean = R::load(static::BEAN_NAME, $idEntity);

        // Box to return correct type for type hinting
        return $bean->box();
    }

    /**
     * @inheritdoc
     */
    public function getMultipleById(array $entitiesIds) : array
    {
        $beans = R::loadAll(static::BEAN_NAME, $entitiesIds);
        return RedBeanUtils::boxArray($beans);
    }

    /**
     * @inheritdoc
     */
    public function findAll() : array
    {
        $beans = R::findAll(static::BEAN_NAME);
        return RedBeanUtils::boxArray($beans);
    }
}
