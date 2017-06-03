<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\ImageInterface;

/**
 * Repository for {@link ImageInterface} entities.
 *
 * @method ImageInterface create()
 * @method int store(ImageInterface $image)
 * @method int[] storeMultiple(array $images)
 * @method void trash(ImageInterface $image)
 * @method void trashMultiple(array $images)
 * @method ImageInterface getById(int $idImage)
 * @method ImageInterface[] getMultipleById(array $idsImages)
 * @method ImageInterface[] findAll()
 */
interface ImageRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'image';

    /**
     * Get image by id or dispense if not exists.
     * @param int $imageId
     * @return \RJ\PronosticApp\Model\Entity\ImageInterface
     */
    public function getByIdOrCreate(int $imageId) : ImageInterface;
}
