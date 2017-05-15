<?php

namespace RJ\PronosticApp\Model\Validator;

abstract class AbstractValidator
{
    /**
     * Validate data form entity.
     * @return ValidationResult
     */
    abstract public function validate() : ValidationResult;
}