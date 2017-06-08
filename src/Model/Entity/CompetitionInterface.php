<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Interface CompetitionInterface
 *
 * All models of competitions must implement this interface.
 *
 * @package RJ\PronosticApp\Model\Entity
 */
interface CompetitionInterface
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
     * @param ImageInterface $image
     */
    public function setImage(ImageInterface $image): void;

    /**
     * @return ImageInterface
     */
    public function getImage(): ImageInterface;
}
