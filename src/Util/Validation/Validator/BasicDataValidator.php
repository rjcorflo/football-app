<?php

namespace RJ\PronosticApp\Util\Validation\Validator;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as V;
use RJ\PronosticApp\Util\Validation\General\ValidationResult;

class BasicDataValidator extends AbstractValidator
{
    /**
     * @var ValidationResult
     */
    protected $result;

    /**
     * @param $identifier
     * @return $this
     */
    public function validateId($identifier)
    {
        try {
            V::intVal()->assert($identifier);
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage(sprintf("Error validando el campo 'url': %s", $e->getFullMessage()));
        }

        return $this;
    }
}
