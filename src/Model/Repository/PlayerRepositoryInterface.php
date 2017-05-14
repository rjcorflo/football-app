<?php

namespace RJ\FootballApp\Model\Repository;

use RJ\FootballApp\Model\Entity\PlayerInterface;

interface PlayerRepositoryInterface
{
    /**
     * Return fresh created player model. Is it not persisted.
     * @return PlayerInterface
     */
    public function create() : PlayerInterface;

    /**
     * Persist player.
     * @param PlayerInterface $player
     * @return int ID of created player.
     */
    public function store(PlayerInterface $player) : int;

    /**
     * Persists multiple players at once.
     * @param PlayerInterface[] $players
     * @return int[] Array of IDs.
     */
    public function storeMultiple(array $players) : array;

    /**
     * Delete player.
     * @param PlayerInterface $player
     * @return void
     */
    public function trash(PlayerInterface $player) : void;

    /**
     * Delete multiples players.
     * @param PlayerInterface[] $players
     * @return void
     */
    public function trashMultiple(array $players) : void;

    /**
     * Get player by id.
     * @param int $playerId
     * @return PlayerInterface
     */
    public function getById(int $playerId) : PlayerInterface;

    /**
     * Get various players by id.
     * @param int[] $playersIds
     * @return PlayerInterface[] List of players.
     */
    public function getMultipleById(array $playersIds) : array;

    /**
     * Returns all players.
     * @return PlayerInterface[] List of all players.
     */
    public function findAll() : array;
}
