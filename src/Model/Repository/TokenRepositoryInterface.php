<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\TokenInterface;
use RJ\PronosticApp\Model\Repository\Exception\NotFoundException;

/**
 * Repository for {@link TokenInterface} entities.
 *
 * @method TokenInterface create()
 * @method int store(TokenInterface $token)
 * @method int[] storeMultiple(array $tokens)
 * @method void trash(TokenInterface $token)
 * @method void trashMultiple(array $tokens)
 * @method TokenInterface getById(int $idToken)
 * @method TokenInterface[] getMultipleById(array $idsTokens)
 * @method TokenInterface[] findAll()
 */
interface TokenRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'token';

    /**
     * Generate a new token with a random string already setted.
     *
     * @return TokenInterface
     */
    public function createRandomToken() : TokenInterface;

    /**
     * Find token by string.
     *
     * @param  string $tokenString
     * @return TokenInterface
     * @throws NotFoundException
     * @throws \Exception
     */
    public function findByTokenString(string $tokenString) : TokenInterface;
}
