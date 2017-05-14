<?php

namespace RJ\PronosticApp\Persistence\RedBeanPersistence\Model\Entity;

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

    /**
     * @inheritDoc
     */
    public function getPlayers() : array
    {
        return $this->participantRepository->listPlayersFromCommunity($this);
    }

    public function addPlayer(PlayerInterface $player) : void
    {
        $this->participantRepository->addPlayerToCommunity($player, $this);
    }

    public function removePlayer(PlayerInterface $player) : void
    {
        $this->participantRepository->removePlayerFromCommunity($player, $this);
    }
}