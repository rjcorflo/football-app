<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Image;

/**
 * Class ImageRepository
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 * @method ImageInterface create()
 * @method int store(ImageInterface $image)
 * @method int[] storeMultiple(array $images)
 * @method void trash(ImageInterface $image)
 * @method void trashMultiple(array $images)
 * @method ImageInterface getById(int $idImage)
 * @method ImageInterface getMultipleById(array $idsImages)
 * @method ImageInterface[] findAll()
 */
class ImageRepository extends AbstractRepository implements ImageRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getByIdOrCreate(int $imageId) : ImageInterface
    {
        /**
         * @var Image $image
         */
        $image = R::findOneOrDispense(self::ENTITY, 'id = :id', [':id' => $imageId]);

        return $image->box();
    }
}
