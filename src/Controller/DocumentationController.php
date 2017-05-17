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

        $newContent = str_replace('{{{server}}}', $request->getServerParams()['HTTP_HOST'], $content);

        return $response->getBody()->write($newContent);
    }
}
