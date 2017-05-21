<?php

namespace RJ\PronosticApp\Util\Validation\Validator;

use RJ\PronosticApp\Util\Validation\General\ValidationResult;

abstract class AbstractValidator
{
    /**
     * @var ValidationResult
     */
    protected $result;

    /**
     * AbstractValidator constructor.
     */
    public function __construct()
    {
        $this->result = new ValidationResult();
    }

    /**
     * Return validations of all data.
     * @return ValidationResult
     */
    public function validate() : ValidationResult
    {
        return $this->result;
    }
}
