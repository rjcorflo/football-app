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
        return $this->bean->matchday;
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
        return $this->bean->local_team;
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
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function getImage(): ImageInterface
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function setImage(ImageInterface $image): void
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function getStadium(): string
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function setStadium(string $stadium): void
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function getTag(): string
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function setTag(string $tag): void
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function getLastModifiedDate(): \DateTime
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function setLastModifiedDate(\DateTime $lastModified): void
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function getState(): string
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function setState(string $state = self::STATE_NOT_PLAYED): void
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function setLocalGoals(int $goals = 0): void
    {
        throw new \LogicException('Not implemented'); // TODO
    }


    /**
     * @inheritDoc
     */
    public function getLocalGoals(): int
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function getAwayGoals(): int
    {
        throw new \LogicException('Not implemented'); // TODO
    }

    /**
     * @inheritDoc
     */
    public function setAwayGoals(int $goals = 0): void
    {
        throw new \LogicException('Not implemented'); // TODO
    }
}
