<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Interface PhaseInterface.
 *
 * All models of phase must implement this interface.
 *
 * @package RJ\PronosticApp\Model\Entity
 */
interface PhaseInterface
{
    /**
     * @return int
     */
    public function getId(): int;

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
    public function getAlias(): string;

    /**
     * @param float $factor
     */
    public function setMultiplierFactor(float $factor): void;

    /**
     * @return float
     */
    public function getMultiplierFactor(): float;
}
