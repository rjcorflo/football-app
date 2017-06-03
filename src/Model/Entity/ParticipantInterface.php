<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Interface ParticipantInterface
 *
 * All models of participant must implement this interface.
 *
 * @package RJ\PronosticApp\Model\Entity
 */
interface ParticipantInterface
{
    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @param PlayerInterface $player
     */
    public function setPlayer(PlayerInterface $player) : void;

    /**
     * @return PlayerInterface
     */
    public function getPlayer() : PlayerInterface;

    /**
     * @param CommunityInterface $community
     */
    public function setCommunity(CommunityInterface $community) : void;

    /**
     * @return CommunityInterface
     */
    public function getCommunity() : CommunityInterface;

    /**
     * @param \DateTime $date
     */
    public function setCreationDate(\DateTime $date) : void;

    /**
     * @return \DateTime
     */
    public function getCreationDate() : \DateTime;
}
