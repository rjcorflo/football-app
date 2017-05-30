<?php
namespace RJ\PronosticApp\App\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;
use Slim\Handlers\PhpError;
use Slim\Http\Body;
use UnexpectedValueException;

/**
 * Default Slim application error handler for PHP 7+ Throwables
 *
 * It outputs the error message and diagnostic information in either JSON, XML,
 * or HTML based on the Accept header.
 */
class PhpErrorHandler extends PhpError
{
    private $resourceGenerator;

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
     * @param \Throwable             $error     The caught Throwable object
     *
     * @return ResponseInterface
     * @throws UnexpectedValueException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Throwable $error)
    {
        $result = new MessageResult();
        $result->isError();
        $result->setDescription("Error insesperado. Avise al administrador del servidor.");
        $result->addMessageWithCode(MessageResult::DEFAULT, $error->getMessage());

        $this->writeToErrorLog($error);

        $body = new Body(fopen('php://temp', 'r+'));
        $body->write($this->resourceGenerator->createMessageResource($result));

        return $response
            ->withStatus(500)
            ->withHeader('Content-type', "application/json")
            ->withBody($body);
    }
}
