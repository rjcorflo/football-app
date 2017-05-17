<?php
namespace RJ\PronosticApp\App\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;
use Slim\Handlers\NotFound;
use Slim\Http\Body;
use UnexpectedValueException;

/**
 * Default Slim application not found handler.
 *
 * It outputs a simple message in either JSON, XML or HTML based on the
 * Accept header.
 */
class NotFoundHandler extends NotFound
{
    /**
     * @var \RJ\PronosticApp\WebResource\WebResourceGeneratorInterface
     */
    private $resourceGenerator;

    /**
     * NotFoundHandler constructor.
     * @param \RJ\PronosticApp\WebResource\WebResourceGeneratorInterface $resourceGenerator
     */
    public function __construct(WebResourceGeneratorInterface $resourceGenerator)
    {
        $this->resourceGenerator = $resourceGenerator;
    }

    /**
     * Invoke not found handler
     *
     * @param  ServerRequestInterface $request  The most recent Request object
     * @param  ResponseInterface      $response The most recent Response object
     *
     * @return ResponseInterface
     * @throws UnexpectedValueException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $result = new MessageResult();
        $result->isError();
        $result->setDescription("Recurso no encontrado.");

        $body = new Body(fopen('php://temp', 'r+'));
        $body->write($this->resourceGenerator->createMessageResource($result));

        return $response->withStatus(404)
                        ->withHeader('Content-Type', "application/json")
                        ->withBody($body);
    }
}
