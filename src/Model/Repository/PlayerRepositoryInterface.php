<?php

namespace RJ\FootballApp\Model\Repository;

use RJ\FootballApp\Model\Entity\PlayerInterface;

interface PlayerRepositoryInterface
{
    public function create() : PlayerInterface;

    public function store(PlayerInterface $entity);

    /**
     * @param PlayerInterface[] $entities
     * @return mixed
     */
    public function storeMultiple(array $entities);

    public function trash(PlayerInterface $entity);

    /**
     * @param PlayerInterface[] $entities
     * @return mixed
     */
    public function trashMultiple(array $entities);

    public function getById(int $idEntity) : PlayerInterface;
}
