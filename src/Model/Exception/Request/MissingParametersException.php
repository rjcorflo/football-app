<?php

namespace RJ\PronosticApp\Model\Exception\Request;

use RJ\PronosticApp\Model\Exception\PronosticAppException;

/**
 * Exception when there are missing parameters in the request.
 *
 * @package RJ\PronosticApp\Model\Repository\Exception
 */
class MissingParametersException extends PronosticAppException
{
    protected $responseCode = 400;

    protected $responseStatus = 'Faltan parametros';
}
