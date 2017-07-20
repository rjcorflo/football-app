<?php

namespace RJ\PronosticApp\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use RJ\PronosticApp\Model\Entity\Extensions\Timestampable;

/**
 * Player
 *
 * @ORM\Entity
 * @ORM\Table(name="players")
 */
class Player
{
    use Timestampable;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="first_name")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="last_name")
     */
    private $lastName;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="id_avatar")
     */
    private $idAvatar;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $color;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     *
     * @return Player
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Player
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Player
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Player
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Player
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set idAvatar
     *
     * @param integer $idAvatar
     *
     * @return Player
     */
    public function setIdAvatar($idAvatar)
    {
        $this->idAvatar = $idAvatar;

        return $this;
    }

    /**
     * Get idAvatar
     *
     * @return integer
     */
    public function getIdAvatar()
    {
        return $this->idAvatar;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Player
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
}

