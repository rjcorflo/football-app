<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\MatchdayClassificationInterface;

/**
 * Repository for {@link MatchdayClassificationInterface} entities.
 *
 * @method MatchdayClassificationInterface create()
 * @method int store(MatchdayClassificationInterface $classification)
 * @method int[] storeMultiple(array $classifications)
 * @method void trash(MatchdayClassificationInterface $classification)
 * @method void trashMultiple(array $classifications)
 * @method MatchdayClassificationInterface getById(int $idClassification)
 * @method MatchdayClassificationInterface[] getMultipleById(array $idsClassifications)
 * @method MatchdayClassificationInterface[] findAll()
 */
interface MatchdayClassificationRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'matchdayclassification';
}
