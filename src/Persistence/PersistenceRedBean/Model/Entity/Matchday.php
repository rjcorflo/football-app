<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\CompetitionInterface;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\PhaseInterface;
use RJ\PronosticApp\Model\Entity\TeamInterface;

/**
 * Class Matchday.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity
 */
class Matchday extends SimpleModel implements MatchdayInterface
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
    public function setCompetition(CompetitionInterface $competition): void
    {
        $this->bean->competition = $competition;
    }

    /**
     * @inheritDoc
     */
    public function getCompetition(): CompetitionInterface
    {
        return $this->bean->competition;
    }

    /**
     * @inheritDoc
     */
    public function setPhase(PhaseInterface $phase): void
    {
        $this->bean->phase = $phase;
    }

    /**
     * @inheritDoc
     */
    public function getPhase(): PhaseInterface
    {
        return $this->bean->phase;
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
}
