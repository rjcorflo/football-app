<?php
namespace RJ\PronosticApp\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\Util\Validation\ValidatorInterface;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;
use Slim\Http\Response;

class DocumentationController
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

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
