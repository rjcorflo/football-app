<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ParticipantInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Class Participant.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity
 */
class Participant extends SimpleModel implements ParticipantInterface
{
    /**
     * @inheritDoc
     */
    public function getId() : int
    {
        return $this->bean->id;
    }

    /**
     * @inheritDoc
     */
    public function setPlayer(PlayerInterface $player): void
    {
        $this->bean->player = $player;
    }

    /**
     * @inheritDoc
     */
    public function getPlayer(): PlayerInterface
    {
        return $this->bean->player;
    }

    /**
     * @inheritDoc
     */
    public function setCommunity(CommunityInterface $community): void
    {
        $this->bean->community = $community;
    }

    /**
     * @inheritDoc
     */
    public function getCommunity(): CommunityInterface
    {
        return $this->bean->community;
    }

    /**
     * @inheritDoc
     */
    public function setCreationDate(\DateTime $date): void
    {
        $this->bean->creation_date = $date;
    }

    /**
     * @inheritDoc
     */
    public function getCreationDate(): \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->bean->creation_date);
    }
}
