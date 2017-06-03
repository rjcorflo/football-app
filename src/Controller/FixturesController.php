<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;

/**
 * Class FixturesController
 *
 * Create fictures and updates.
 *
 * @package RJ\PronosticApp\Controller
 */
class FixturesController
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /**
     * FixturesController constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ResponseInterface $response
     * @return int
     */
    public function fixturesImages(
        ResponseInterface $response
    ) {
        $images = [];

        /** @var ImageRepositoryInterface $imageRepository */
        $imageRepository = $this->entityManager->getRepository(ImageRepositoryInterface::class);

        for ($index = 1; $index < 17; $index++) {
            $image = $imageRepository->getByIdOrCreate($index);
            $image->setUrl("/images/{$index}.jpg");

            $images[] = $image;
        }

        $this->entityManager->transaction(function () use ($imageRepository, $images) {
            $imageRepository->storeMultiple($images);
        });

        return $response->getBody()->write('{result: "OK"}');
    }
}
