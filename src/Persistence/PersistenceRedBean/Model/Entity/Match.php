<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\TeamInterface;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;

/**
 * Class Match.
 *
 * @package RJ\PronosticApp\Persistence\Persistence RedBean\Model\Entity
 */
class Match extends SimpleModel implements MatchInterface
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
    public function setMatchday(MatchdayInterface $matchday): void
    {
        $this->bean->matchday = $matchday;
    }

    /**
     * @inheritDoc
     */
    public function getMatchday(): MatchdayInterface
    {
        return $this->bean->matchday->box();
    }

    /**
     * @inheritDoc
     */
    public function setStartTime(\DateTime $startTime): void
    {
        $this->bean->start_time = $startTime;
    }

    /**
     * @inheritDoc
     */
    public function getStartTime(): \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->bean->start_time);
    }

    /**
     * @inheritDoc
     */
    public function setLocalTeam(TeamInterface $team): void
    {
        $this->bean->local_team = $team;
    }

    /**
     * @inheritDoc
     */
    public function getLocalTeam(): TeamInterface
    {
        return $this->bean->local_team->box();
    }

    /**
     * @inheritDoc
     */
    public function setAwayTeam(TeamInterface $team): void
    {
        $this->bean->away_team = $team;
    }

    /**
     * @inheritDoc
     */
    public function getAwayTeam(): TeamInterface
    {
        return $this->bean->away_team->box();
    }

    /**
     * @inheritDoc
     */
    public function setLocalGoals(int $goals = 0): void
    {
        $this->bean->local_goals = $goals;
    }

    /**
     * @inheritDoc
     */
    public function getLocalGoals(): int
    {
        return $this->bean->local_goals;
    }

    /**
     * @inheritDoc
     */
    public function setAwayGoals(int $goals = 0): void
    {
        $this->bean->away_goals = $goals;
    }

    /**
     * @inheritDoc
     */
    public function getAwayGoals(): int
    {
        return $this->bean->away_goals;
    }

    /**
     * @inheritDoc
     */
    public function setState(string $state = self::STATE_NOT_PLAYED): void
    {
        $this->bean->state = $state;
    }

    /**
     * @inheritDoc
     */
    public function getState(): string
    {
        return $this->bean->state;
    }

    /**
     * @inheritDoc
     */
    public function setTag(string $tag): void
    {
        $this->bean->tag = $tag;
    }

    /**
     * @inheritDoc
     */
    public function getTag(): string
    {
        return $this->bean->tag;
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
        return $this->bean->city;
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
