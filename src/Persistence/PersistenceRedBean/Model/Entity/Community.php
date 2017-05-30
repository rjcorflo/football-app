<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository\ParticipantRepository;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

class Community extends SimpleModel implements CommunityInterface
{
    private $participantRepository;

    public function __construct()
    {
        $this->participantRepository = new ParticipantRepository();
    }

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
    public function setCommunityName(string $communityName) : void
    {
        $this->bean->name = $communityName;
    }

    /**
     * @inheritdoc
     */
    public function getCommunityName() : string
    {
        return $this->bean->name;
    }

    /**
     * @inheritdoc
     */
    public function setPassword(string $password) : void
    {
        $this->bean->password = $password;
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
    public function setPrivate(bool $isPrivate) : void
    {
        $this->bean->private = $isPrivate;
    }

    /**
     * @inheritdoc
     */
    public function isPrivate() : bool
    {
        return (bool) $this->bean->private;
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
     * @inheritDoc
     */
    public function addAdmin(PlayerInterface $player) : void
    {
        $administrator = R::dispense('administrator');
        $administrator->player = $player;

        $this->bean->xownAdministratorList[] = $administrator;
    }

    /**
     * @inheritDoc
     */
    public function removeAdmin(PlayerInterface $player) : void
    {
        unset($this->bean->xownAdministratorList[$player->getId()]);
    }

    /**
     * @inheritDoc
     */
    public function getAdmins() : array
    {
        return $this->xownAdministratorList;
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
     * @inheritDoc
     */
    public function getPlayers() : array
    {
        $players = $this->bean->via(ParticipantRepository::ENTITY)->sharedPlayerList;

        return RedBeanUtils::boxArray($players);
    }

    /**
     * @inheritdoc
     */
    public function addPlayer(PlayerInterface $player) : void
    {
        $participant = R::dispense(ParticipantRepository::ENTITY);
        $participant->community = $this;
        $participant->player = $player;
        $participant->creationDate = new \DateTime();

        R::store($participant);
    }

    /**
     * @inheritdoc
     */
    public function removePlayer(PlayerInterface $player) : void
    {
        unset($this->bean->via(ParticipantRepository::ENTITY)->sharedPlayerList[$player->getId()]);
    }
}
