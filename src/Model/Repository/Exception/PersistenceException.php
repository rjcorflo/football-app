<?php

namespace RJ\PronosticApp\Model\Repository\Exception;

use RJ\PronosticApp\Model\Exception\PronosticAppException;

/**
 * Exception when entity can not be saved in repository.
 *
 * @package RJ\PronosticApp\Model\Repository\Exception
 */
class PersistenceException extends PronosticAppException
{
    protected $responseCode = 404;

    protected $responseStatus = 'Error persistiendo los datos';
}
