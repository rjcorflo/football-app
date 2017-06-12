<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\MatchInterface;

/**
 * Repository for {@link MatchInterface} entities.
 *
 * @method MatchInterface create()
 * @method int store(MatchInterface $match)
 * @method int[] storeMultiple(array $matches)
 * @method void trash(MatchInterface $match)
 * @method void trashMultiple(array $matches)
 * @method MatchInterface getById(int $idMatch)
 * @method MatchInterface[] getMultipleById(array $idsMatches)
 * @method MatchInterface[] findAll()
 */
interface MatchRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'match';
}
