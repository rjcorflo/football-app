<?php

namespace USaq\Service\Validation;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as V;
use USaq\Service\Validation\Exception\FieldValidationException;

class ValidationService
{
    private $usernameValidator;

    private $passwordValidator;

    public function __construct()
    {
        $this->usernameValidator = V::alnum()->length(4, 30);
        $this->passwordValidator = V::alnum()->length(4, 30);
    }

    /**
     * @param $data
     * @throws FieldValidationException
     */
    public function validateRegisterRequest($data): void
    {
        $errors = '';

        try {
            V::keySet(
                V::key('username', $this->usernameValidator),
                V::key('password', $this->passwordValidator),
                V::key('password_repeat', $this->passwordValidator)
            )
            ->keyValue('password_repeat', 'equals', 'password')
            ->assert($data);
        } catch (NestedValidationException $e) {
            $errors = $e->getMessages();

            $exception = new FieldValidationException('Login validation error');
            $exception->addFieldsErrors($errors);
            throw $exception;
        }
    }

    /**
     * @param $data
     * @throws FieldValidationException
     */
    public function validateLoginRequest($data): void
    {
        try {
            V::keySet(
                V::key('username', $this->usernameValidator),
                V::key('password', $this->passwordValidator)
            )
            ->assert($data);
        } catch (NestedValidationException $e) {
            $errors = $e->getMessages();

            $exception = new FieldValidationException('Login validation error');
            $exception->addFieldsErrors($errors);
            throw $exception;
        }
    }
}
