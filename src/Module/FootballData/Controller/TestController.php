<?php

namespace RJ\PronosticApp\Module\FootballData\Controller;

use Psr\Http\Message\ResponseInterface;
use RJ\PronosticApp\Module\FootballData\Service\FootballDataRetriever;

/**
 * Class TestController
 * @package RJ\PronosticApp\Controller
 */
class TestController
{
    /**
     * @var FootballDataRetriever
     */
    private $footballData;

    /**
     * TestController constructor.
     *
     * @param FootballDataRetriever $footballData
     */
    public function __construct(FootballDataRetriever $footballData)
    {
        $this->footballData = $footballData;
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function test(
        ResponseInterface $response
    ) {
        $response->getBody()->write('TEXTO');
        return $response;
    }
}
