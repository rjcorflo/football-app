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
     * @var WebResourceGeneratorInterface
     */
    protected $resourceGenerator;

    /**
     * Base Controller constructor.
     *
     * @param WebResourceGeneratorInterface $resourceGenerator
     */
    public function __construct(
        WebResourceGeneratorInterface $resourceGenerator
    ) {
        $this->resourceGenerator = $resourceGenerator;
    }
}
