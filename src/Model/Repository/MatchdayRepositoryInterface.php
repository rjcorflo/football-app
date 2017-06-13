<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\MatchdayInterface;

/**
 * Repository for {@link MatchdayInterface} entities.
 *
 * @method MatchdayInterface create()
 * @method int store(MatchdayInterface $matchday)
 * @method int[] storeMultiple(array $matchdays)
 * @method void trash(MatchdayInterface $matchday)
 * @method void trashMultiple(array $matchdays)
 * @method MatchdayInterface getById(int $idMatchday)
 * @method MatchdayInterface[] getMultipleById(array $idsMatchdays)
 * @method MatchdayInterface[] findAll()
 */
interface MatchdayRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'matchday';

    /**
     * Get next matchday.
     *
     * @return null|MatchdayInterface
     */
    public function getNextMatchday(): ?MatchdayInterface;

    /**
     * Return all matchdays orderder by order field.
     *
     * @return MatchdayInterface[]
     */
    public function findAllOrdered(): array;
}
