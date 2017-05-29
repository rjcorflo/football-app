<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;

interface CommunityRepositoryInterface extends StandardRepositoryInterface
{
    const ENTITY = 'community';

    /**
     * Check if a community name exists.
     * @param string $name
     * @return bool
     */
    public function checkIfNameExists(string $name) : bool;
}
