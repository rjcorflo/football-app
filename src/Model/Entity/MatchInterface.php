<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Interface MatchInterface.
 *
 * @package RJ\PronosticApp\Model\Entity
 */
interface MatchInterface
{
    /** @var string Match not played yet. */
    const STATE_NOT_PLAYED = "NOT-PLAYED";

    /** @var string Match currently in play. */
    const STATE_PLAYING = "PLAYING";

    /** @var string Match finished. */
    const STATE_FINISHED = "FINISHED";

    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @param MatchdayInterface $matchday
     */
    public function setMatchday(MatchdayInterface $matchday) : void;

    /**
     * @return MatchdayInterface
     */
    public function getMatchday() : MatchdayInterface;

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime(\DateTime $startTime) : void;

    /**
     * @return \DateTime
     */
    public function getStartTime() : \DateTime;

    /**
     * @param TeamInterface $team
     */
    public function setLocalTeam(TeamInterface $team) : void;

    /**
     * @return TeamInterface
     */
    public function getLocalTeam() : TeamInterface;

    /**
     * @param TeamInterface $team
     */
    public function setAwayTeam(TeamInterface $team) : void;

    /**
     * @return TeamInterface
     */
    public function getAwayTeam() : TeamInterface;

    /**
     * @param int $goals
     */
    public function setLocalGoals(int $goals = 0) : void;

    /**
     * @return int
     */
    public function getLocalGoals() : int;

    /**
     * @param int $goals
     */
    public function setAwayGoals(int $goals = 0) : void;

    /**
     * @return int
     */
    public function getAwayGoals() : int;

    /**
     * @param string $state
     */
    public function setState(string $state = self::STATE_NOT_PLAYED) : void;

    /**
     * @return string
     */
    public function getState() : string;

    /**
     * @param \DateTime $lastModified
     */
    public function setLastModifiedDate(\DateTime $lastModified) : void;

    /**
     * @return \DateTime
     */
    public function getLastModifiedDate() : \DateTime;
}
