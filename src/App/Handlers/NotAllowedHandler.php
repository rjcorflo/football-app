<?php
namespace RJ\PronosticApp\App\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;
use Slim\Handlers\NotAllowed;
use Slim\Http\Body;
use UnexpectedValueException;

/**
 * Default Slim application not allowed handler
 *
 * It outputs a simple message in either JSON, XML or HTML based on the
 * Accept header.
 */
class NotAllowedHandler extends NotAllowed
{
    /**
     * @var \RJ\PronosticApp\WebResource\WebResourceGeneratorInterface
     */
    private $resourceGenerator;

    /**
     * NotAllowedHandler constructor.
     * @param \RJ\PronosticApp\WebResource\WebResourceGeneratorInterface $resourceGenerator
     */
    public function __construct(WebResourceGeneratorInterface $resourceGenerator)
    {
        $this->resourceGenerator = $resourceGenerator;
    }

    /**
     * Invoke error handler
     *
     * @param  ServerRequestInterface $request  The most recent Request object
     * @param  ResponseInterface      $response The most recent Response object
     * @param  string[]               $methods  Allowed HTTP methods
     *
     * @return ResponseInterface
     * @throws UnexpectedValueException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $methods)
    {
        $method = $request->getMethod();

        $result = new MessageResult();
        $result->isError();
        $result->setDescription("El verbo $method no es soportado por este recurso.");

        $body = new Body(fopen('php://temp', 'r+'));
        $body->write($this->resourceGenerator->createMessageResource($result));
        $allow = implode(', ', $methods);

        return $response
                ->withStatus(405)
                ->withHeader('Content-type', "application/json")
                ->withHeader('Allow', $allow)
                ->withBody($body);
    }

    /**
     * Render PLAIN not allowed message
     *
     * @param  array                  $methods
     * @return string
     */
    protected function renderPlainNotAllowedMessage($methods)
    {
        $allow = implode(', ', $methods);

        return 'Allowed methods: ' . $allow;
    }

    /**
     * Render JSON not allowed message
     *
     * @param  array                  $methods
     * @return string
     */
    protected function renderJsonNotAllowedMessage($methods)
    {
        $allow = implode(', ', $methods);

        return '{"message":"Method not allowed. Must be one of: ' . $allow . '"}';
    }

    /**
     * Render XML not allowed message
     *
     * @param  array                  $methods
     * @return string
     */
    protected function renderXmlNotAllowedMessage($methods)
    {
        $allow = implode(', ', $methods);

        return "<root><message>Method not allowed. Must be one of: $allow</message></root>";
    }

    /**
     * Render HTML not allowed message
     *
     * @param  array                  $methods
     * @return string
     */
    protected function renderHtmlNotAllowedMessage($methods)
    {
        $allow = implode(', ', $methods);
        $output = <<<END
<html>
    <head>
        <title>Method not allowed</title>
        <style>
            body{
                margin:0;
                padding:30px;
                font:12px/1.5 Helvetica,Arial,Verdana,sans-serif;
            }
            h1{
                margin:0;
                font-size:48px;
                font-weight:normal;
                line-height:48px;
            }
        </style>
    </head>
    <body>
        <h1>Method not allowed</h1>
        <p>Method not allowed. Must be one of: <strong>$allow</strong></p>
    </body>
</html>
END;

        return $output;
    }
}
