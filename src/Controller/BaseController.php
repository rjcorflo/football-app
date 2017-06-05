<?php

namespace RJ\PronosticApp\Controller;

use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Util\General\ResponseGenerator;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

/**
 * Base Controller.
 *
 * Has various service already injected. Serves as template for other controllers.
 *
 * @package RJ\PronosticApp\Controller
 */
abstract class BaseController
{
    use ResponseGenerator;

    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @var WebResourceGeneratorInterface
     */
    protected $resourceGenerator;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

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
}
