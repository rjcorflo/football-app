<?php

namespace RJ\PronosticApp\App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Process\ClassificationCalculationProcess;
use RJ\PronosticApp\Util\General\MessageResult;

/**
 * Class ClassificationController
 *
 * @package RJ\PronosticApp\App\Controller
 */
class ClassificationController extends BaseController
{
    /**
     * Calculate classifications.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function calculateClassifications(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $params = $request->getQueryParams();

        $result = new MessageResult();
        try {
            $result->setDescription('Clasificaciones calculadas');

            $process = new ClassificationCalculationProcess($this->entityManager);
            $process->launch();

            $resource = $this->resourceGenerator->createMessageResource($result);

            $response = $this->generateJsonCorrectResponse($response, $resource);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }
}
