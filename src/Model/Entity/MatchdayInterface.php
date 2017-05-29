<?php

namespace RJ\PronosticApp\Model\Entity;

interface MatchdayInterface
{
    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @param CompetitionInterface $competition
     */
    public function setCompetition(CompetitionInterface $competition) : void;

    /**
     * @return CompetitionInterface
     */
    public function getCompetition() : CompetitionInterface;

    /**
     * @param string $name
     */
    public function setName(string $name) : void;

    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @param string $alias
     */
    public function setAlias(string $alias) : void;

    /**
     * @return string
     */
    public function getAlias() : ?string;
}