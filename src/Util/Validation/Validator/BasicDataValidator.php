<?php

namespace RJ\PronosticApp\Util\Validation\Validator;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as V;
use RJ\PronosticApp\Util\General\ErrorCodes;

/**
 * Validator for basic data.
 *
 * @package RJ\PronosticApp\Util\Validation\Validator
 */
class BasicDataValidator extends AbstractValidator
{
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
            $this->result->addMessageWithCode(
                ErrorCodes::INVALID_ID,
                sprintf("Error validando el campo 'url': %s", $e->getFullMessage())
            );
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function validate(): void
    {
        if ($this->result->hasError()) {
            $this->result->setDescription('Error validando los datos');
        }

        parent::validate();
    }
}
