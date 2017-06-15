<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Interface MatchdayclassificationInterface.
 *
 * @package RJ\PronosticApp\Model\Entity
 */
interface MatchdayclassificationInterface
{
    /**
     * @return int
     */
    public function getId(): int;

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
    public function getBasicPoints(): int;

    /**
     * @param int $points
     */
    public function setBasicPoints(int $points): void;

    /**
     * @return int
     */
    public function getPointsForPosition(): int;

    /**
     * @param int $points
     */
    public function setPointsForPosition(int $points): void;

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
    public function getPosition(): int;

    /**
     * @param int $position
     */
    public function setPosition(int $position): void;

    /**
     * @param \DateTime $lastModified
     */
    public function setLastModifiedDate(\DateTime $lastModified): void;

    /**
     * @return \DateTime
     */
    public function getLastModifiedDate(): \DateTime;
}
