<?php

namespace RJ\PronosticApp\Util\General;

use Psr\Http\Message\ResponseInterface;

/**
 * Trait ResponseGenerator
 *
 * Generate common responses for certain cases.
 *
 * @package RJ\PronosticApp\Util\General
 */
trait ResponseGenerator
{
    /**
     * Generate a reponse with code 400 when mandatory parameters has been not passed to the request
     *
     * @param ResponseInterface $response
     * @param string $message
     * @return ResponseInterface
     */
    public function generateParameterNeededResponse(ResponseInterface $response, string $message)
    {
        $result = new MessageResult();
        $result->isError();
        $result->setDescription('Faltan parámetros obligatorios');
        $result->addMessageWithCode(
            ErrorCodes::MISSING_PARAMETERS,
            $message
        );
        $response->getBody()->write($this->resourceGenerator->createMessageResource($result));
        $response = $response->withStatus(400, 'Parameters needed');
        return $response;
    }
}
