<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;

class FixturesController
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fixturesImages(
        ResponseInterface $response
    ) {
        $images = [];

        /** @var ImageRepositoryInterface $imageRepository */
        $imageRepository = $this->entityManager->getRepository(ImageRepositoryInterface::class);

        for ($index = 1; $index < 17; $index++) {
            $image = $imageRepository->getByIdOrCreate(1);
            $image->setUrl("/images/{$index}.jpg");

            $images[] = $image;
        }

        $this->entityManager->transaction(function () use ($imageRepository, $images) {
            $imageRepository->storeMultiple($images);
        });

        return $response->getBody()->write('OK');
    }
}
