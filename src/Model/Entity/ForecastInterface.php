<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Interface ForecastInterface
 *
 *  All models of forecast must implement this interface.
 *
 * @package RJ\PronosticApp\Model\Entity
 */
interface ForecastInterface
{
    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @param PlayerInterface $player
     */
    public function setPlayer(PlayerInterface $player): void;

    /**
     * @return PlayerInterface
     */
    public function getPlayer(): PlayerInterface;

    /**
     * @param CommunityInterface $community
     */
    public function setCommunity(CommunityInterface $community): void;

    /**
     * @return CommunityInterface
     */
    public function getCommunity(): CommunityInterface;

    /**
     * @param MatchInterface $match
     */
    public function setMatch(MatchInterface $match): void;

    /**
     * @return MatchInterface
     */
    public function getMatch(): MatchInterface;

    /**
     * @param int $goals
     */
    public function setLocalGoals(int $goals): void;

    /**
     * @return int
     */
    public function getLocalGoals(): int;

    /**
     * @param int $goals
     */
    public function setAwayGoals(int $goals): void;

    /**
     * @return int
     */
    public function getAwayGoals(): int;

    /**
     * @param bool $risk
     */
    public function setRisk(bool $risk): void;

    /**
     * @return bool
     */
    public function isRisk(): bool;

    /**
     * @param int $points
     */
    public function setPoints(int $points): void;

    /**
     * @return int
     */
    public function getPoints(): int;

    /**
     * @param \DateTime $date
     */
    public function setLastModifiedDate(\DateTime $date): void;

    /**
     * @return \DateTime
     */
    public function getLastModifiedDate(): \DateTime;
}
