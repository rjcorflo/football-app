<?php

namespace RJ\FootballApp\Model\Repository;

use RJ\FootballApp\Model\Entity\CommunityInterface;

interface CommunityRepositoryInterface
{
    public function create() : CommunityInterface;

    public function store(CommunityInterface $entity);

    /**
     * @param CommunityInterface[] $entities
     * @return mixed
     */
    public function storeMultiple(array $entities);

    public function trash(CommunityInterface $entity);

    /**
     * @param CommunityInterface[] $entities
     * @return mixed
     */
    public function trashMultiple(array $entities);

    public function getById(int $idEntity) : CommunityInterface;
}
