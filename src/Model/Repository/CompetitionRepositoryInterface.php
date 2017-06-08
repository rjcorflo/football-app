<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CompetitionInterface;

/**
 * Repository for {@link CompetitionInterface} entities.
 *
 * @method CompetitionInterface create()
 * @method int store(CompetitionInterface $competition)
 * @method int[] storeMultiple(array $competitions)
 * @method void trash(CompetitionInterface $competition)
 * @method void trashMultiple(array $competitions)
 * @method CompetitionInterface getById(int $idCompetition)
 * @method CompetitionInterface[] getMultipleById(array $idsCompetitions)
 * @method CompetitionInterface[] findAll()
 */
interface CompetitionRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'competition';
}
