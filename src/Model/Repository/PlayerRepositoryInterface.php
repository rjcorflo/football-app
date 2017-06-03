<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Repository for {@link PlayerInterface} entities.
 *
 * @method PlayerInterface create()
 * @method int store(PlayerInterface $player)
 * @method int[] storeMultiple(array $players)
 * @method void trash(PlayerInterface $player)
 * @method void trashMultiple(array $players)
 * @method PlayerInterface getById(int $idPlayer)
 * @method PlayerInterface[] getMultipleById(array $idsPlayers)
 * @method PlayerInterface[] findAll()
 */
interface PlayerRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'player';

    /**
     * Checks if nickname exists.
     * @param string $nickname
     * @return bool
     */
    public function checkNickameExists(string $nickname) : bool;

    /**
     * Check if email exists.
     * @param string $email
     * @return bool
     */
    public function checkEmailExists(string $email) : bool;

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
