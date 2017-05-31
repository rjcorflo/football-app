<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

class ImagesController
{
    /** @var EntityManager $entityManager */
    private $entityManager;

    /** @var WebResourceGeneratorInterface */
    private $resourceGenerator;

    public function __construct(
        EntityManager $entityManager,
        WebResourceGeneratorInterface $resourceGenerator
    ) {
        $this->entityManager = $entityManager;
        $this->resourceGenerator = $resourceGenerator;
    }

    public function list(
        ResponseInterface $response
    ) {
        /** @var ImageRepositoryInterface $imageRepository */
        $imageRepository = $this->entityManager->getRepository(ImageRepositoryInterface::class);

        $images = $imageRepository->findAll();

        return $response->getBody()->write($this->resourceGenerator->createImageResource($images));
    }
}
