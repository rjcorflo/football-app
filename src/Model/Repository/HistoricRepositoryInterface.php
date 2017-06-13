<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\HistoricInterface;

/**
 * Repository for {@link HistoricInterface} entities.
 *
 * @method HistoricInterface create()
 * @method int store(HistoricInterface $classification)
 * @method int[] storeMultiple(array $classifications)
 * @method void trash(HistoricInterface $classification)
 * @method void trashMultiple(array $classifications)
 * @method HistoricInterface getById(int $idClassification)
 * @method HistoricInterface[] getMultipleById(array $idsClassifications)
 * @method HistoricInterface[] findAll()
 */
interface HistoricRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'historic';
}
