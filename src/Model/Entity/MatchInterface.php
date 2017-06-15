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
    const STATE_NOT_PLAYED = 0;

    /** @var string Match currently in play. */
    const STATE_PLAYING = 1;

    /** @var string Match finished. */
    const STATE_FINISHED = 2;

    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @param MatchdayInterface $matchday
     */
    public function setMatchday(MatchdayInterface $matchday): void;

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
     * @param string $tag
     */
    public function setTag(string $tag): void;

    /**
     * @return string
     */
    public function getTag(): string;

    /**
     * @param string $stadium
     */
    public function setStadium(string $stadium): void;

    /**
     * @return string
     */
    public function getStadium(): string;

    /**
     * @param string $city
     */
    public function setCity(string $city): void;

    /**
     * @return string
     */
    public function getCity(): string;

    /**
     * @param ImageInterface $image
     */
    public function setImage(ImageInterface $image): void;

    /**
     * @return ImageInterface
     */
    public function getImage(): ImageInterface;

    /**
     * @param \DateTime $lastModified
     */
    public function setLastModifiedDate(\DateTime $lastModified) : void;

    /**
     * @return \DateTime
     */
    public function getLastModifiedDate() : \DateTime;
}
