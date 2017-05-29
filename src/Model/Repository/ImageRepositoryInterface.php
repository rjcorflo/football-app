<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\ImageInterface;

interface ImageRepositoryInterface extends StandardRepositoryInterface
{
    const ENTITY = 'image';

    /**
     * Get image by id or dispense if not exists.
     * @param int $imageId
     * @return \RJ\PronosticApp\Model\Entity\ImageInterface
     */
    public function getByIdOrCreate(int $imageId) : ImageInterface;
}
