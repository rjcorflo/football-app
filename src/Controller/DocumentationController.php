<?php

namespace RJ\PronosticApp\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class DocumentationController.
 *
 * @package RJ\PronosticApp\Controller
 */
class DocumentationController
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * DocumentationController constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Return Swagger docuemntation file stream.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function documentationSwagger(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $content = file_get_contents($this->container->get('app.docsDir') . "/swagger-api-v1.yaml");

        $replaces = [
            'server' => $request->getServerParams()['HTTP_HOST']
        ];

        $response->getBody()->write($this->stringReplace($content, $replaces));

        return $response;
    }

    /**
     * String replace mustaches {{}}.
     *
     * @param $string
     * @param array $replaces
     * @return string
     */
    private function stringReplace(string $string, array $replaces): string
    {
        foreach ($replaces as $key => $value) {
            $string = str_replace('{{' . strtolower($key) . '}}', $value, $string);
        }

        return $string;
    }
}
