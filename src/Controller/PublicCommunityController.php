<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

/**
 * Class PublicCommunityController.
 *
 * Expose public community data.
 *
 * @package RJ\PronosticApp\Controller
 */
class PublicCommunityController
{
    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * @var WebResourceGeneratorInterface
     */
    private $resourceGenerator;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * CommunityController constructor.
     * @param EntityManager $entityManager
     * @param WebResourceGeneratorInterface $resourceGenerator
     * @param ValidatorInterface $validator
     */
    public function __construct(
        EntityManager $entityManager,
        WebResourceGeneratorInterface $resourceGenerator,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->resourceGenerator = $resourceGenerator;
        $this->validator = $validator;
    }

    /**
     * List all public communities.
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function list(
        ResponseInterface $response
    ) {
        /** @var CommunityRepositoryInterface $communityRepository */
        $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

        $communities = $communityRepository->getAllPublicCommunities();

        $response->getBody()->write($this->resourceGenerator->createPublicCommunityResource($communities));
        return $response;
    }
}
