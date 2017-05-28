<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Competition interface.
 */
interface CompetitionInterface
{
    /**
     * @return int
     */
    public function getId() : int;

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
    public function getAlias() : string;
}
