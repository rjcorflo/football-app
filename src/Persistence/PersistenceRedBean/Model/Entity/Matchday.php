<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\CompetitionInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\PhaseInterface;

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
        return $this->bean->competition->box();
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
        return $this->bean->phase->box();
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
    public function setOrder(int $order = 1): void
    {
        $this->bean->matchday_order = $order;
    }

    /**
     * @inheritDoc
     */
    public function getOrder(): int
    {
        return $this->bean->matchday_order;
    }

    /**
     * @inheritDoc
     */
    public function setLastModifiedDate(\DateTime $lastModified): void
    {
        $this->bean->last_modified_date = $lastModified;
    }

    /**
     * @inheritDoc
     */
    public function getLastModifiedDate(): \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->bean->last_modified_date);
    }
}
