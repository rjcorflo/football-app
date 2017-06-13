<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\GeneralClassificationInterface;

/**
 * Repository for {@link GeneralClassificationInterface} entities.
 *
 * @method GeneralClassificationInterface create()
 * @method int store(GeneralClassificationInterface $classification)
 * @method int[] storeMultiple(array $classifications)
 * @method void trash(GeneralClassificationInterface $classification)
 * @method void trashMultiple(array $classifications)
 * @method GeneralClassificationInterface getById(int $idClassification)
 * @method GeneralClassificationInterface[] getMultipleById(array $idsClassifications)
 * @method GeneralClassificationInterface[] findAll()
 */
interface GeneralClassificationRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'generalclassification';
}
