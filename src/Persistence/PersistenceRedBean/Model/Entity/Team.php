<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Entity\TeamInterface;

/**
 * Class Team.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity
 */
class Team extends SimpleModel implements TeamInterface
{
    /**
     * @inheritdoc
     */
    public function getId() : int
    {
        return $this->bean->id;
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): void
    {
        $this->bean->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->bean->name;
    }

    /**
     * @inheritDoc
     */
    public function setAlias(string $alias): void
    {
        $this->bean->alias = $alias;
    }

    /**
     * @inheritDoc
     */
    public function getAlias(): string
    {
        return $this->bean->alias;
    }

    /**
     * @inheritDoc
     */
    public function setStadium(string $stadium): void
    {
        $this->bean->stadium = $stadium;
    }

    /**
     * @inheritDoc
     */
    public function getStadium(): string
    {
        return $this->bean->stadium;
    }

    /**
     * @inheritDoc
     */
    public function setCity(string $city): void
    {
        $this->bean->city = $city;
    }

    /**
     * @inheritDoc
     */
    public function getCity(): string
    {
        return $this->bean->city ?? '';
    }

    /**
     * @inheritDoc
     */
    public function setImage(ImageInterface $image): void
    {
        $this->bean->image = $image;
    }

    /**
     * @inheritDoc
     */
    public function getImage(): ImageInterface
    {
        return $this->bean->image->box();
    }

    /**
     * @inheritDoc
     */
    public function setColor(string $color): void
    {
        $this->bean->color = $color;
    }

    /**
     * @inheritDoc
     */
    public function getColor(): string
    {
        return $this->bean->color;
    }
}
