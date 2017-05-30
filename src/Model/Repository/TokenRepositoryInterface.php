<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\TokenInterface;

interface TokenRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'token';

    /**
     * Find token by string.
     * @param  string         $tokenString
     * @return TokenInterface
     */
    public function findByTokenString(string $tokenString) : TokenInterface;
}
