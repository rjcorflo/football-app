<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Image;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

class ImageRepository implements ImageRepositoryInterface
{
    const BEAN_NAME = 'image';

    /**
     * @inheritDoc
     */
    public function create() : ImageInterface
    {
        /**
         * @var Image $image
         */
        $image = R::dispense(self::BEAN_NAME);

        return $image->box();
    }

    /**
     * @inheritDoc
     */
    public function store(ImageInterface $image) : int
    {
        if (!$image instanceof Image) {
            throw new \Exception("Object must be an instance of Image");
        }

        return R::store($image);
    }

    /**
     * @inheritDoc
     */
    public function trash(ImageInterface $image) : void
    {
        if (!$image instanceof Image) {
            throw new \Exception("Object must be an instance of Image");
        }

        R::trash($image);
    }

    /**
     * @inheritDoc
     */
    public function getById(int $imageId) : ImageInterface
    {
        /**
         * @var Image $image
         */
        $image = R::load(self::BEAN_NAME, $imageId);

        return $image->box();
    }

    /**
     * @inheritDoc
     */
    public function getByIdOrCreate(int $imageId) : ImageInterface
    {
        /**
         * @var Image $image
         */
        $image = R::findOneOrDispense(self::BEAN_NAME, 'id = :id', [':id' => $imageId]);

        return $image->box();
    }

    /**
     * @inheritDoc
     */
    public function findAll() : array
    {
        $images = R::findAll(self::BEAN_NAME);

        return RedBeanUtils::boxArray($images);
    }
}
