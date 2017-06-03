<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Image;

/**
 * Class ImageRepository
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
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
