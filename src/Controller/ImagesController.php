<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use RJ\PronosticApp\Model\Repository\ImageRepositoryInterface;

/**
 * Class ImagesController
 *
 * Operate over images.
 *
 * @package RJ\PronosticApp\Controller
 */
class ImagesController extends BaseController
{
    /**
     * List images.
     *
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function list(ResponseInterface $response): ResponseInterface
    {
        /** @var ImageRepositoryInterface $imageRepository */
        $imageRepository = $this->entityManager->getRepository(ImageRepositoryInterface::class);

        try {
            $images = $imageRepository->findAll();

            $resource = $this->resourceGenerator->createImageResource($images);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }
}
