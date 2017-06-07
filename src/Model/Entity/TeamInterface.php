<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Interface TeamInterface.
 *
 * All models of teams must implement this interface.
 *
 * @package RJ\PronosticApp\Model\Entity
 */
interface TeamInterface
{
    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @param string $name
     */
    public function setName(string $name) : void;

    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @param string $alias
     */
    public function setAlias(string $alias) : void;

    /**
     * @return string
     */
    public function getAlias() : string;

    /**
     * @param string $stadium
     */
    public function setStadium(string $stadium): void;

    /**
     * @return string
     */
    public function getStadium(): string;

    /**
     * @param ImageInterface $image
     */
    public function setImage(ImageInterface $image): void;

    /**
     * @return ImageInterface
     */
    public function getImage(): ImageInterface;
}
