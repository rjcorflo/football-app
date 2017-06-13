<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Interface HistoricInterface.
 *
 * @package RJ\PronosticApp\Model\Entity
 */
interface HistoricInterface
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
     * @param CommunityInterface $matchday
     */
    public function setCommunity(CommunityInterface $matchday): void;

    /**
     * @return CommunityInterface
     */
    public function getCommunity(): CommunityInterface;

    /**
     * @return MatchdayInterface
     */
    public function getMatchday(): MatchdayInterface;

    /**
     * @param MatchdayInterface $matchday
     */
    public function setMatchday(MatchdayInterface $matchday): void;

    /**
     * @param int $position
     */
    public function setPosition(int $position): void;

    /**
     * @return int
     */
    public function getPosition(): int;
}
