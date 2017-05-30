<?php

namespace RJ\PronosticApp\Model\Repository;

interface StandardRepositoryInterface
{
    /**
     * Name of the entity.
     * @var string
     */
    const ENTITY = 'override-this';

    /**
     * Return fresh created entity model. Is it not persisted.
     * @return object
     */
    public function create();

    /**
     * Persist entity.
     * @param $entity
     * @return int ID of created entity.
     */
    public function store($entity) : int;

    /**
     * Persists multiple entities at once.
     * @param array $entities
     * @return int[] Array of IDs.
     */
    public function storeMultiple(array $entities) : array;

    /**
     * Delete entity.
     * @param object $entity
     * @return void
     */
    public function trash($entity) : void;

    /**
     * Delete multiples entities.
     * @param array $entities
     * @return void
     */
    public function trashMultiple(array $entities) : void;

    /**
     * Get entity by id.
     * @param int $entityId
     * @return object
     */
    public function getById(int $entityId);

    /**
     * Get various entities by id.
     * @param int[] $entitiesIds
     * @return array List of entities.
     */
    public function getMultipleById(array $entitiesIds) : array;

    /**
     * Returns all entities.
     * @return array List of all entities.
     */
    public function findAll() : array;
}
