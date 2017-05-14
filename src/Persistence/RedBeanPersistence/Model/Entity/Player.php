<?php

namespace RJ\FootballApp\Persistence\RedBeanPersistence\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\FootballApp\Model\Entity\PlayerInterface;

class Player extends SimpleModel implements PlayerInterface
{

    public function getId() : int
    {
        return $this->bean->id;
    }

    public function setNickname(string $nickname) : void
    {
        $this->bean->nickname = $nickname;
    }

    public function getNickname() : string
    {
        return $this->nickname;
    }

    public function setEmail(string $email) : void
    {
        $this->bean->email = $email;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    public function getPassword() : string
    {
        return $this->bean->password;
    }

    public function setFirstName(string $firstName) : void
    {
        $this->bean->firstName = $firstName;
    }

    public function getFirstName() : string
    {
        return $this->bean->firstName;
    }

    public function setLastName(string $lastName) : void
    {
        $this->bean->lastName = $lastName;
    }

    public function getLasName() : string
    {
        return $this->bean->lastName;
    }

    public function setCreationDate(\DateTime $date) : void
    {
        $this->bean->creation_date = $date;
    }

    public function getCreationDate() : \DateTime
    {
        return $this->bean->creation_date;
    }

    /**
     * @inheritdoc
     */
    public function getPlayerCommunities() : array
    {
        return $this->bean->sharedCommunityList;
    }
}
