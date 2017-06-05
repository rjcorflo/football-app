<?php
namespace RJ\PronosticApp\App\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Util\General\ErrorCodes;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;
use Slim\Handlers\Error;
use Slim\Http\Body;
use UnexpectedValueException;

class ErrorHandler extends Error
{
    /**
     * @var WebResourceGeneratorInterface
     */
    private $resourceGenerator;

    /**
     * ErrorHandler constructor.
     * @param bool $displayErrorDetails
     * @param WebResourceGeneratorInterface $resourceGenerator
     */
    public function __construct($displayErrorDetails, WebResourceGeneratorInterface $resourceGenerator)
    {
        parent::__construct($displayErrorDetails);
        $this->resourceGenerator = $resourceGenerator;
    }

    /**
     * Invoke error handler
     *
     * @param ServerRequestInterface $request   The most recent Request object
     * @param ResponseInterface      $response  The most recent Response object
     * @param \Exception             $exception The caught Exception object
     *
     * @return ResponseInterface
     * @throws UnexpectedValueException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Exception $exception)
    {
        $result = new MessageResult();
        $result->isError();
        $result->setDescription("Exception inesperada. Avise al administrador del servidor.");
        $result->addMessageWithCode(ErrorCodes::DEFAULT_ERROR, $exception->getMessage());

        $this->writeToErrorLog($exception);

        $body = new Body(fopen('php://temp', 'r+'));
        $body->write($this->resourceGenerator->createMessageResource($result));

        return $response
                ->withStatus(500)
                ->withHeader('Content-type', "application/json")
                ->withBody($body);
    }
}
