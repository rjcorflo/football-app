<?php
namespace RJ\PronosticApp\Model\Entity;

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

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname) : void;

    /**
     * @return string
     */
    public function getNickname() : string;

    /**
     * @param string $email
     */
    public function setEmail(string $email) : void;

    /**
     * @return string
     */
    public function getEmail() : string;

    /**
     * @param string $password
     */
    public function setPassword(string $password) : void;

    /**
     * @return string
     */
    public function getPassword() : string;

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName) : void;

    /**
     * @return string
     */
    public function getFirstName() : string;

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName) : void;

    /**
     * @return string
     */
    public function getLastName() : string;

    /**
     * @param \DateTime $date
     */
    public function setCreationDate(\DateTime $date) : void;

    /**
     * @return \DateTime
     */
    public function getCreationDate() : \DateTime;

    /**
     * @param ImageInterface $image
     */
    public function setImage(ImageInterface $image) : void;

    /**
     * @return \RJ\PronosticApp\Model\Entity\ImageInterface
     */
    public function getImage() : ImageInterface;

    /**
     * @param string $color
     */
    public function setColor(string $color) : void;

    /**
     * @return string
     */
    public function getColor() : string;

    /**
     * Return user's communities.
     *
     * @return CommunityInterface[] List of communities to which the player belongs.
     */
    public function getPlayerCommunities() : array;

    /**
     * @param TokenInterface $token
     */
    public function addToken(TokenInterface $token) : void;

    /**
     * @param TokenInterface $idToken
     */
    public function removeToken(TokenInterface $idToken) : void;

    /**
     * @return TokenInterface[]
     */
    public function getTokens() :array;
}
