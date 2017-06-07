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
     * @param CommunityInterface $
     */
    public function setCommunity(CommunityInterface $matchday): void;

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
    public function getPosition(): int;

    /**
     * @param int $position
     */
    public function setPosition(int $position): void;
}
