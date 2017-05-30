<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Entity\TokenInterface;

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
     * Generate one token for player.
     * @param PlayerInterface $player
     * @return TokenInterface
     */
    public function generateTokenForPlayer(PlayerInterface $player) : TokenInterface;

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
