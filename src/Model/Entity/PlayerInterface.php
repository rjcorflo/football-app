<?php
namespace RJ\FootballApp\Model\Entity;

/**
 * Interface PlayerInterface.
 *
 * All models of players must implements this interface.
 */
interface PlayerInterface
{
    /**
     * @return int Player ID.
     */
    public function getId() : int;

    public function setNickname(string $nickname) : void;

    public function getNickname() : string;

    public function setEmail(string $email) : void;

    public function getEmail() : string;

    public function setPassword(string $password) : void;

    public function getPassword() : string;

    public function setFirstName(string $firstName) : void;

    public function getFirstName() : string;

    public function setLastName(string $lastName) : void;

    public function getLasName() : string;

    public function setCreationDate(\DateTime $date) : void;

    public function getCreationDate() : \DateTime;

    /**
     * Return user's communities.
     *
     * @return CommunityInterface[] List of communities to which the player belongs.
     */
    public function getPlayerCommunities() : array;
}
