<?php

namespace RJ\PronosticApp\Model\Validator;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as V;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

class PlayerValidator extends AbstractValidator
{
    /**
     * @var PlayerInterface Player.
     */
    private $player;

    /**
     * @var ValidationResult
     */
    private $result;

    public function __construct(PlayerInterface $player)
    {
        $this->player = $player;
        $this->result = new ValidationResult();
    }

    public function validate() : ValidationResult
    {
        try {
            V::alnum()->length(3, 20)->assert($this->player->getNickname());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage($e->getFullMessage());
        }

        try {
            V::notBlank()->notOptional()->notEmpty()->assert($this->player->getPassword());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage($e->getFullMessage());
        }

        try {
            V::email()->assert($this->player->getEmail());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage($e->getFullMessage());
        }

        try {
            V::optional(V::alpha()->length(3, 60))->assert($this->player->getFirstName());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage($e->getFullMessage());
        }

        try {
            V::optional(V::alpha()->length(3, 100))->assert($this->player->getLasName());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage($e->getFullMessage());
        }

        return $this->result;
    }
}
