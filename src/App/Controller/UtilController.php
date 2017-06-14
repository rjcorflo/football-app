<?php

namespace RJ\PronosticApp\App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class UtilController.
 *
 * @package RJ\PronosticApp\App\Controller
 */
class UtilController extends BaseController
{
    public function serverDate(
        ServerRequestInterface $request,
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
