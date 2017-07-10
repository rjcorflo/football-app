<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;

/**
 * Class UtilController.
 *
 * @package RJ\PronosticApp\App\Controller
 */
class UtilController extends BaseController
{
    /**
     * Get date from server.
     *
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function serverDate(
        ResponseInterface $response
    ): ResponseInterface {
        $date = new \DateTime();

        $resource = [
            'fecha_actual' => $date->format('Y-m-d H:i:s')
        ];

        $response = $this->generateJsonCorrectResponse($response, json_encode($resource));

        return $response;
    }
}
