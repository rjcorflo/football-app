<?php

namespace Persistence\RedBeanPersistence\Model\Entity;

use Model\Entity\TokenInterface;
use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

class Token extends SimpleModel implements TokenInterface
{
    public function getId()
    {
        return $this->bean->id;
    }

    public function setPlayer(PlayerInterface $player)
    {
       $this->bean->player;
    }

    public function getPlayer() : PlayerInterface
    {
        return $this->bean->player;
    }

    public function setToken(string $token)
    {
        $this->bean->token = $token;
    }

    public function getToken() : string
    {
        return $this->bean->token;
    }
}