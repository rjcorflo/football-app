<?php

namespace RJ\PronosticApp\Model\Repository;

interface CommunityRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'community';

    /**
     * Check if a community name exists.
     * @param string $name
     * @return bool
     */
    public function checkIfNameExists(string $name) : bool;
}
