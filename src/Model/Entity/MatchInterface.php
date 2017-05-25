<?php

namespace RJ\PronosticApp\Model\Entity;

interface MatchInterface
{
    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @param \RJ\PronosticApp\Model\Entity\MatchdayInterface $matchday
     */
    public function setMatchday(MatchdayInterface $matchday) : void;

    /**
     * @return \RJ\PronosticApp\Model\Entity\MatchdayInterface
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
     * @param \RJ\PronosticApp\Model\Entity\TeamInterface $team
     */
    public function setLocalTeam(TeamInterface $team) : void;

    /**
     * @return \RJ\PronosticApp\Model\Entity\TeamInterface
     */
    public function getLocalTeam() : TeamInterface;

    /**
     * @param \RJ\PronosticApp\Model\Entity\TeamInterface $team
     */
    public function setAwayTeam(TeamInterface $team) : void;

    /**
     * @return \RJ\PronosticApp\Model\Entity\TeamInterface
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
    public function setState(string $state) : void;

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
