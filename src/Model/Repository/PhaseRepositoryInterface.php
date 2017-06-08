<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\PhaseInterface;

/**
 * Repository for {@link PhaseInterface} entities.
 *
 * @method PhaseInterface create()
 * @method int store(PhaseInterface $phase)
 * @method int[] storeMultiple(array $phases)
 * @method void trash(PhaseInterface $phase)
 * @method void trashMultiple(array $phases)
 * @method PhaseInterface getById(int $idPhase)
 * @method PhaseInterface[] getMultipleById(array $idsPhases)
 * @method PhaseInterface[] findAll()
 */
interface PhaseRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'phase';
}
