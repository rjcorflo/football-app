<?php

namespace RJ\FootballApp\Persistence\RedBeanPersistence\Model\Repository;

use RedBeanPHP\R;
use RedBeanPHP\SimpleModel;
use RJ\FootballApp\Model\Entity\PlayerInterface;
use RJ\FootballApp\Model\Repository\PlayerRepositoryInterface;
use RJ\FootballApp\Persistence\RedBeanPersistence\Model\Entity\Player;

class PlayerRepository implements PlayerRepositoryInterface
{
    const BEAN_NAME = 'player';

    public function create() : PlayerInterface
    {
        /**
         * @var Player $bean
         */
        $bean = R::dispense(self::BEAN_NAME);

        // Box to return correct type for type hinting
        return $bean->box();
    }

    public function store(PlayerInterface $entity) : int
    {
        if (!$entity instanceof Player) {
            throw new \Exception("Object must be an instance of Player");
        }

        return R::store($entity);
    }

    public function storeMultiple(array $entities) : array
    {
        return R::storeAll($entities);
    }

    public function trash(PlayerInterface $entity) : void
    {
        if (!$entity instanceof Player) {
            throw new \Exception("Object must be an instance of Player");
        }

        R::trash($entity);
    }

    public function trashMultiple(array $entities) : void
    {
        R::trashAll($entities);
    }

    public function getById(int $idEntity) : PlayerInterface
    {
        /**
         * @var Player $bean
         */
        $bean = R::load(self::BEAN_NAME, $idEntity);

        // Box to return correct type for type hinting
        return $bean->box();
    }

    public function getMultipleById(array $playersIds) : array
    {
        $beans = R::loadAll(self::BEAN_NAME, $playersIds);

        return $this->boxArray($beans);
    }

    /**
     * @inheritdoc
     */
    public function findAll() : array
    {
        return R::findAll(self::BEAN_NAME);
    }

    /**
     * @param SimpleModel[] $beans Beans from database.
     * @return Player[] Models associated to beans retrieved.
     */
    private function boxArray(array $beans) : array
    {
        $models = [];

        foreach ($beans as $bean) {
            $models[] = $bean->box();
        }

        return $models;
    }
}
