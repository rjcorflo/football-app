<?php

namespace RJ\PronosticApp\Model\Repository\Exception;

use RJ\PronosticApp\Model\Exception\PronosticAppException;

/**
 * Exception when entity not found in repository.
 *
 * @package RJ\PronosticApp\Model\Repository\Exception
 */
class NotFoundException extends PronosticAppException
{
    protected $responseCode = 404;

    protected $responseStatus = 'N se ha encontrado el recurso';
}
