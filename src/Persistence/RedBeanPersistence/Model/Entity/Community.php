<?php

namespace Persistence\RedBeanPersistence\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\FootballApp\Model\Entity\CommunityInterface;
use RJ\FootballApp\Model\Entity\PlayerInterface;

class Community extends  SimpleModel implements CommunityInterface
{

    public function getId() : int
    {
        return $this->bean->id;
    }

    public function setCommunityName(string $communityName)
    {
        $this->bean->name;
    }

    public function getCommunityName() : string
    {
        return $this->bean->name;
    }

    public function setPassword(string $password)
    {
        $this->bean->password = $password;
    }

    public function getPassword() : string
    {
        return $this->bean->password;
    }

    public function setPrivate(bool $isPrivate)
    {
        $this->bean->private = $isPrivate;
    }

    public function isPrivate() : bool
    {
        return $this->bean->private;
    }

    public function setCreationDate(\DateTime $date)
    {
        $this->bean->creation_date = $date;
    }

    public function getCreationDate() : \DateTime
    {
        return $this->bean->creation_date;
    }

    public function addPlayer(PlayerInterface $player) : void
    {
        $this->bean->sharedPlayerList[] = $player;
    }

    public function removePlayer(PlayerInterface $player) : void
    {
        $this->bean->sharedPlayerList[$player->getId()];
    }
}