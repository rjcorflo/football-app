<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Interface MatchdayInterface
 *
 * @package RJ\PronosticApp\Model\Entity
 */
interface MatchdayInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param CompetitionInterface $competition
     */
    public function setCompetition(CompetitionInterface $competition): void;

    /**
     * @return CompetitionInterface
     */
    public function getCompetition(): CompetitionInterface;

    /**
     * @param PhaseInterface $phase
     */
    public function setPhase(PhaseInterface $phase): void;

    /**
     * @return PhaseInterface
     */
    public function getPhase(): PhaseInterface;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $alias
     */
    public function setAlias(string $alias): void;

    /**
     * @return string
     */
    public function getAlias(): ?string;

    /**
     * @param int $order
     */
    public function setOrder(int $order = 1): void;

    /**
     * @return int
     */
    public function getOrder(): int;
}
