<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\TeamInterface;

/**
 * Repository for {@link TeamInterface} entities.
 *
 * @method TeamInterface create()
 * @method int store(TeamInterface $team)
 * @method int[] storeMultiple(array $teams)
 * @method void trash(TeamInterface $team)
 * @method void trashMultiple(array $teams)
 * @method TeamInterface getById(int $idTeam)
 * @method TeamInterface[] getMultipleById(array $idsTeams)
 * @method TeamInterface[] findAll()
 */
interface TeamRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'team';
}
