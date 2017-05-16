<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Entity\TokenInterface;

class Token extends SimpleModel implements TokenInterface
{
    /**
     * @inheritdoc
     */
    public function getId() : int
    {
        return $this->bean->id;
    }

    /**
     * @inheritdoc
     */
    public function setPlayer(PlayerInterface $player) : void
    {
        $this->bean->player = $player;
    }

    /**
     * @inheritdoc
     */
    public function getPlayer() : PlayerInterface
    {
        return $this->bean->player->box();
    }

    /**
     * @inheritdoc
     */
    public function setToken(string $token) : void
    {
        $this->bean->token = $token;
    }

    /**
     * @inheritdoc
     */
    public function getToken() : string
    {
        return $this->bean->token;
    }
}
