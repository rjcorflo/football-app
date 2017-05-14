<?php

namespace Model\Entity;

use RJ\PronosticApp\Model\Entity\PlayerInterface;

interface TokenInterface
{
    public function getId();

    public function setPlayer(PlayerInterface $player);

    public function getPlayer() : PlayerInterface;

    public function setToken(string $token);

    public function getToken() : string;
}