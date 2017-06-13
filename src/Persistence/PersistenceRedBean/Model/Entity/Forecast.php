<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ForecastInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Class Forecast.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity
 */
class Forecast extends SimpleModel implements ForecastInterface
{
    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->bean->id;
    }

    /**
     * @inheritDoc
     */
    public function setPlayer(PlayerInterface $player): void
    {
        $this->bean->player = $player;
    }

    /**
     * @inheritDoc
     */
    public function getPlayer(): PlayerInterface
    {
        return $this->bean->player->box();
    }

    /**
     * @inheritDoc
     */
    public function setCommunity(CommunityInterface $community): void
    {
        $this->bean->community = $community;
    }

    /**
     * @inheritDoc
     */
    public function getCommunity(): CommunityInterface
    {
        return $this->bean->community->box();
    }

    /**
     * @inheritDoc
     */
    public function setMatch(MatchInterface $match): void
    {
        $this->bean->match = $match;
    }

    /**
     * @inheritDoc
     */
    public function getMatch(): MatchInterface
    {
        return $this->bean->match->box();
    }

    /**
     * @inheritDoc
     */
    public function setLocalGoals(int $goals): void
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
    public function setAwayGoals(int $goals): void
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
    public function setRisk(bool $risk): void
    {
        $this->bean->risk = $risk;
    }

    /**
     * @inheritDoc
     */
    public function isRisk(): bool
    {
        return (bool) $this->bean->risk;
    }

    /**
     * @inheritDoc
     */
    public function setPoints(int $points): void
    {
        $this->bean->points = $points;
    }

    /**
     * @inheritDoc
     */
    public function getPoints(): int
    {
        return $this->bean->points ?? 0;
    }

    /**
     * @inheritDoc
     */
    public function setLastModifiedDate(\DateTime $date): void
    {
        $this->bean->last_modified_date = $date;
    }

    /**
     * @inheritDoc
     */
    public function getLastModifiedDate(): \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->bean->last_modified_date);
    }
}
