<?php

namespace RJ\PronosticApp\Model\Validator;

abstract class AbstractValidator
{
    abstract public function validate() : ValidationResult;
}