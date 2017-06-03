<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\TokenInterface;

/**
 * Repository for {@link TokenInterface} entities.
 *
 * @method TokenInterface create()
 * @method int store(TokenInterface $image)
 * @method int[] storeMultiple(array $images)
 * @method void trash(TokenInterface $image)
 * @method void trashMultiple(array $images)
 * @method TokenInterface getById(int $idImage)
 * @method TokenInterface[] getMultipleById(array $idsImages)
 * @method TokenInterface[] findAll()
 */
interface TokenRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'token';

    /**
     * Generate a new token with a random string already setted.
     * @return TokenInterface
     */
    public function createRandomToken() : TokenInterface;

    /**
     * Find token by string.
     * @param  string         $tokenString
     * @return TokenInterface
     */
    public function findByTokenString(string $tokenString) : TokenInterface;
}
