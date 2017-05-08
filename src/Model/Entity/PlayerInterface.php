<?php
namespace RJ\FootballApp\Model\Entity;

/**
 * Interface PlayerInterface.
 *
 * All models of players must implements this interface.
 */
interface PlayerInterface
{
    public function getId() : int;

    public function setNickname(string $nickname);

    public function getNickname() : string;

    public function setEmail(string $email);

    public function getEmail() : string;

    public function setPassword(string $password);

    public function getPassword() : string;

    public function setFirstName(string $firstName);

    public function getFirstName() : string;

    public function setLastName(string $lastName) : string;

    public function getLasName() : string;

    public function setCreationDate(\DateTime $date);

    public function getCreationDate() : \DateTime;

    /**
     * Return user's communities.
     *
     * @return CommunityInterface[] List of communities to which the player belongs.
     */
    public function getPlayerCommunities() : array;
}
