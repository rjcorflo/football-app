<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\TokenInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

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

    public function checkNickameExists(string $nickname) : bool;

    public function checkEmailExists(string $email) : bool;

    /**
     * Generate one token for player.
     * @param PlayerInterface $player
     * @return TokenInterface
     */
    public function generateTokenForPlayer(PlayerInterface $player) : TokenInterface;

    /**
     * @param PlayerInterface $player
     * @param string $token
     */
    public function removePlayerToken(PlayerInterface $player, string $token) : void;

    /**
     * Find player by nickname or email.
     * @param string $name
     * @return PlayerInterface[] List of players.
     */
    public function findPlayerByNicknameOrEmail(string $name) : array;

    /**
     * @param string $token
     * @return PlayerInterface Player.
     */
    public function findPlayerByToken(string $token) : PlayerInterface;
}
