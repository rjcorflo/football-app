<?php
namespace RJ\PronosticApp\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class DocumentationController
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
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return int
     */
    public function documentationSwagger(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $content = file_get_contents($this->container->get('app.docsDir') . "/swagger-api-v1.yaml");

        $replaces = [
            'server' => $request->getServerParams()['HTTP_HOST']
        ];

        return $response->getBody()->write($this->stringReplace($content, $replaces));
    }

    private function stringReplace($string, array $replaces) : string
    {
        foreach ($replaces as $key => $value) {
            $string = str_replace('{{'.strtolower($key).'}}', $value, $string);
        }

        return $string;
    }
}
