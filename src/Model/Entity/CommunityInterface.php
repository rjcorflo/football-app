<?php

namespace RJ\FootballApp\Model\Entity;

interface CommunityInterface
{
    public function getId() : int;

    public function setCommunityName(string $communityName) : void;

    public function getCommunityName() : string;

    public function setPassword(string $password) : void;

    public function getPassword() : string;

    public function setPrivate(bool $isPrivate) : void;

    public function isPrivate() : bool;

    public function setCreationDate(\DateTime $date) : void;

    public function getCreationDate() : \DateTime;

    /**
     * Get the list of players from the community.
     * @return PlayerInterface[] List of player from this community.
     */
    public function getPlayers() : array;

    /**
     * Add a player to community.
     * @param PlayerInterface $player
     */
    public function addPlayer(PlayerInterface $player) : void;

    /**
     * Remove a player from the community.
     * @param PlayerInterface $player
     */
    public function removePlayer(PlayerInterface $player) : void;
}
