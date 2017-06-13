<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Interface MatchdayClassificationInterface.
 *
 * @package RJ\PronosticApp\Model\Entity
 */
interface MatchdayClassificationInterface
{
    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @return PlayerInterface
     */
    public function getPlayer(): PlayerInterface;

    /**
     * @param PlayerInterface $player
     */
    public function setPlayer(PlayerInterface $player): void;

    /**
     * @return CommunityInterface
     */
    public function getCommunity(): CommunityInterface;

    /**
     * @param CommunityInterface $community
     */
    public function setCommunity(CommunityInterface $community): void;

    /**
     * @return MatchdayInterface
     */
    public function getMatchday(): MatchdayInterface;

    /**
     * @param MatchdayInterface $matchday
     */
    public function setMatchday(MatchdayInterface $matchday): void;

    /**
     * @return int
     */
    public function getTotalPoints(): int;

    /**
     * @param int $points
     */
    public function setTotalPoints(int $points): void;

    /**
     * @return int
     */
    public function getHitsTenPoints(): int;

    /**
     * @param int $hits
     */
    public function setHitsTenPoints(int $hits): void;

    /**
     * @return int
     */
    public function getHitsFivePoints(): int;

    /**
     * @param int $hits
     */
    public function setHitsFivePoints(int $hits): void;

    /**
     * @return int
     */
    public function getHitsThreePoints(): int;

    /**
     * @param int $hits
     */
    public function setHitsThreePoints(int $hits): void;

    /**
     * @return int
     */
    public function getHitsTwoPoints(): int;

    /**
     * @param int $hits
     */
    public function setHitsTwoPoints(int $hits): void;

    /**
     * @return int
     */
    public function getHitsOnePoints(): int;

    /**
     * @param int $hits
     */
    public function setHitsOnePoints(int $hits): void;

    /**
     * @return int
     */
    public function getHitsNegativePoints(): int;

    /**
     * @param int $hits
     */
    public function setHitsNegativePoints(int $hits): void;

    /**
     * @return int
     */
    public function getTimesFirst(): int;

    /**
     * @param int $times
     */
    public function setTimesFirst(int $times): void;

    /**
     * @return int
     */
    public function getTimesSecond(): int;

    /**
     * @param int $times
     */
    public function setTimesSecond(int $times): void;

    /**
     * @return int
     */
    public function getTimesThird(): int;

    /**
     * @param int $times
     */
    public function setTimesThird(int $times): void;
}
