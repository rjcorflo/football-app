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
        return (bool)$this->bean->risk;
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

    /**
     * @inheritDoc
     */
    public function calculateActualPoints(): void
    {
        $match = $this->getMatch();

        if ($match->getState() === MatchInterface::STATE_NOT_PLAYED) {
            $this->setPoints(0);
            return;
        } elseif ($match->getLocalGoals() == -1 && $match->getAwayGoals() == -1) {
            $this->setPoints(0);
            return;
        }

        // Calculate points
        $points = 0;

        if ($this->exactResult($match)) {
            $points = 5;
        } elseif ($this->correctResultWithSameDifferenceInGoals($match)) {
            $points = 3;
        } elseif ($this->correctResultWithOneExactResult($match)) {
            $points = 2;
        } elseif ($this->correctResult($match)) {
            $points = 1;
        }

        // Correcciones a los puntos
        if ($this->isRisk()) {
            $points = $this->exactResult($match) ? 10 : -1;
        }

        $this->setPoints($points);
    }

    /**
     * Check exact result.
     * @param MatchInterface $match
     * @return bool
     */
    private function exactResult(MatchInterface $match): bool
    {
        return $match->getLocalGoals() == $this->getLocalGoals()
            && $match->getAwayGoals() == $this->getAwayGoals();
    }

    /**
     * Check difference in goals and correct winning team.
     * @param MatchInterface $match
     * @return bool
     */
    private function correctResultWithSameDifferenceInGoals(MatchInterface $match): bool
    {
        return $match->getLocalGoals() - $match->getAwayGoals()
            == $this->getLocalGoals() - $this->getAwayGoals();
    }

    /**
     * Check
     * @param MatchInterface $match
     * @return bool
     */
    private function correctResult(MatchInterface $match): bool
    {
        return ($match->getLocalGoals() - $match->getAwayGoals()) *
            ($this->getLocalGoals() - $this->getAwayGoals()) > 0
            || ($match->getLocalGoals() - $match->getAwayGoals() == 0
                && $this->getLocalGoals() - $this->getAwayGoals() == 0);
    }

    /**
     * @param MatchInterface $match
     * @return bool
     */
    private function oneExactResult(MatchInterface $match): bool
    {
        return $match->getLocalGoals() == $this->getLocalGoals()
            || $match->getAwayGoals() == $this->getAwayGoals();
    }

    /**
     * @param MatchInterface $match
     * @return bool
     */
    private function correctResultWithOneExactResult(MatchInterface $match): bool
    {
        return $this->correctResult($match) && $this->oneExactResult($match);
    }
}
