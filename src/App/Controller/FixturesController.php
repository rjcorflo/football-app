<?php

namespace RJ\PronosticApp\App\Controller;

use Psr\Http\Message\ResponseInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;

/**
 * Class FixturesController
 *
 * Create fixtures and updates.
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
     * Fixtures for images.
     *
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function fixturesImages(ResponseInterface $response): ResponseInterface
    {
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

        $response->getBody()->write('{result: "OK"}');

        return $response;
    }
}
