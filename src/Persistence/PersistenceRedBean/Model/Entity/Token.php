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
    public function getId()
    {
        return $this->bean->id;
    }

    /**
     * @inheritdoc
     */
    public function setPlayer(PlayerInterface $player)
    {
        $this->bean->player;
    }

    /**
     * @inheritdoc
     */
    public function getPlayer() : PlayerInterface
    {
        return $this->bean->player;
    }

    /**
     * @inheritdoc
     */
    public function setToken(string $token)
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
