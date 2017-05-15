<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

class Community extends SimpleModel implements CommunityInterface
{
    private $participantRepository;

    public function __construct(ParticipantRepositoryInterface $participantRepository)
    {
        $this->participantRepository = $participantRepository;
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
    public function setCommunityName(string $communityName)
    {
        $this->bean->name;
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
    public function setPassword(string $password)
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
    public function setPrivate(bool $isPrivate)
    {
        $this->bean->private = $isPrivate;
    }

    /**
     * @inheritdoc
     */
    public function isPrivate() : bool
    {
        return $this->bean->private;
    }

    /**
     * @inheritdoc
     */
    public function setCreationDate(\DateTime $date)
    {
        $this->bean->creation_date = $date;
    }

    /**
     * @inheritdoc
     */
    public function getCreationDate() : \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s' , $this->bean->creation_date);
    }

    /**
     * @inheritDoc
     */
    public function getPlayers() : array
    {
        return $this->participantRepository->listPlayersFromCommunity($this);
    }

    /**
     * @inheritdoc
     */
    public function addPlayer(PlayerInterface $player) : void
    {
        $this->participantRepository->addPlayerToCommunity($player, $this);
    }

    /**
     * @inheritdoc
     */
    public function removePlayer(PlayerInterface $player) : void
    {
        $this->participantRepository->removePlayerFromCommunity($player, $this);
    }
}