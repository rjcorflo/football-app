<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\CompetitionInterface;
use RJ\PronosticApp\Model\Entity\ImageInterface;

/**
 * Class Competition.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity
 */
class Competition extends SimpleModel implements CompetitionInterface
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
}
