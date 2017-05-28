<?php

namespace RJ\PronosticApp\Model\Entity;

interface TokenInterface
{
    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @param PlayerInterface $player
     */
    public function setPlayer(PlayerInterface $player) : void;

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
}
