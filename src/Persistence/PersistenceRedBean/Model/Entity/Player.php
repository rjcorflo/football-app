<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Entity\TokenInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository\ParticipantRepository;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

class Player extends SimpleModel implements PlayerInterface
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
    public function setNickname(string $nickname) : void
    {
        $this->bean->nickname = $nickname;
    }

    /**
     * @inheritdoc
     */
    public function getNickname() : string
    {
        return $this->nickname;
    }

    /**
     * @inheritdoc
     */
    public function setEmail(string $email) : void
    {
        $this->bean->email = $email;
    }

    /**
     * @inheritdoc
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @inheritdoc
     */
    public function setPassword(string $password) : void
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @inheritdoc
     */
    public function getPassword() : string
    {
        return $this->bean->password;
    }

    /**
     * @inheritdoc
     */
    public function setFirstName(string $firstName) : void
    {
        $this->bean->firstName = $firstName;
    }

    /**
     * @inheritdoc
     */
    public function getFirstName() : string
    {
        return $this->bean->firstName ?? '';
    }

    /**
     * @inheritdoc
     */
    public function setLastName(string $lastName) : void
    {
        $this->bean->lastName = $lastName;
    }

    /**
     * @inheritdoc
     */
    public function getLastName() : string
    {
        return $this->bean->lastName ?? '';
    }

    /**
     * @inheritdoc
     */
    public function setCreationDate(\DateTime $date) : void
    {
        $this->bean->creation_date = $date;
    }

    /**
     * @inheritdoc
     */
    public function getCreationDate() : \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->bean->creation_date);
    }

    /**
     * @inheritdoc
     */
    public function getPlayerCommunities() : array
    {
        $communities = $this->bean->via(ParticipantRepository::BEAN_NAME)->sharedCommunityList;

        return RedBeanUtils::boxArray($communities);
    }

    /**
     * @inheritDoc
     */
    public function setImage(ImageInterface $image) : void
    {
        $this->bean->image = $image;
    }

    /**
     * @inheritDoc
     */
    public function getImage() : ImageInterface
    {
        return $this->bean->image->box();
    }

    /**
     * @inheritDoc
     */
    public function setColor(string $color) : void
    {
        $this->bean->color = $color;
    }

    /**
     * @inheritDoc
     */
    public function getColor() : string
    {
        return $this->bean->color;
    }


    /**
     * @inheritdoc
     */
    public function addToken(TokenInterface $token) : TokenInterface
    {
        $this->bean->xownTokenList[] = $token;

        return $token;
    }

    /**
     * @inheritdoc
     */
    public function removeToken(TokenInterface $token) : void
    {
        unset($this->bean->xownTokenList[$token->getId()]);
    }

    /**
     * @inheritdoc
     */
    public function getTokens() : array
    {
        return $this->bean->xownTokenList;
    }
}
