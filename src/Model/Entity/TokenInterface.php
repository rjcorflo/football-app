<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Interface TokenInterface
 *
 * All models of tokens must implement this interface.
 *
 * @package RJ\PronosticApp\Model\Entity
 */
interface TokenInterface
{
    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @return PlayerInterface
     */
    public function getPlayer() : PlayerInterface;

    /**
     * @param string $token
     */
    public function setToken(string $token) : void;

    /**
     * @return string
     */
    public function getToken() : string;

    /**
     * Generate a random string token.
     */
    public function generateRandomToken() : void;
}
