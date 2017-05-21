<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\ImageInterface;

interface ImageRepositoryInterface
{
    /**
     * Return fresh created image model. Is it not persisted.
     * @return ImageInterface
     */
    public function create() : ImageInterface;

    /**
     * Persist image.
     * @param ImageInterface $image
     * @return int ID of created image.
     */
    public function store(ImageInterface $image) : int;

    /**
     * Delete image.
     * @param ImageInterface $image
     * @return mixed
     */
    public function trash(ImageInterface $image) : void;

    /**
     * Get images by id.
     * @param int $imageId
     * @return ImageInterface
     */
    public function getById(int $imageId) : ImageInterface;

    /**
     * Get image by id or dispense if not exists.
     * @param int $imageId
     * @return \RJ\PronosticApp\Model\Entity\ImageInterface
     */
    public function getByIdOrCreate(int $imageId) : ImageInterface;

    /**
     * Returns all images.
     * @return ImageInterface[] List of all images.
     */
    public function findAll() : array;
}
