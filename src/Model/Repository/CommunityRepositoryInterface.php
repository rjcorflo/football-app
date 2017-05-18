<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;

interface CommunityRepositoryInterface
{
    /**
     * Return fresh created community model. Is it not persisted.
     * @return CommunityInterface
     */
    public function create() : CommunityInterface;

    /**
     * Persist community.
     * @param CommunityInterface $community
     * @return int ID of created community.
     */
    public function store(CommunityInterface $community) : int;

    /**
     * Persists multiple communities at once.
     * @param CommunityInterface[] $entities
     * @return mixed
     */
    public function storeMultiple(array $entities) : array;

    /**
     * Delete community.
     * @param CommunityInterface $community
     * @return mixed
     */
    public function trash(CommunityInterface $community) : void;

    /**
     * Delete multiples communities.
     * @param CommunityInterface[] $entities
     * @return void
     */
    public function trashMultiple(array $entities) : void;

    /**
     * Get communities by id.
     * @param int $communityId
     * @return CommunityInterface
     */
    public function getById(int $communityId) : CommunityInterface;

    /**
     * Get various players by id.
     * @param int[] $playersIds
     * @return CommunityInterface[] List of players.
     */
    public function getMultipleById(array $playersIds) : array;

    /**
     * Returns all players.
     * @return CommunityInterface[] List of all players.
     */
    public function findAll() : array;

    /**
     * Check if a community name exists.
     * @param string $name
     * @return bool
     */
    public function checkIfNameExists(string $name) : bool;
}
