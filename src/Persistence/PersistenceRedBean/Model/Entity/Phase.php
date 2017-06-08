<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\CompetitionInterface;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Entity\PhaseInterface;
use RJ\PronosticApp\Model\Entity\TeamInterface;

/**
 * Class Phase.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity
 */
class Phase extends SimpleModel implements PhaseInterface
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
    public function setMultiplierFactor(float $factor): void
    {
        $this->bean->factor = $factor;
    }

    /**
     * @inheritDoc
     */
    public function getMultiplierFactor(): float
    {
        return $this->bean->factor;
    }
}
