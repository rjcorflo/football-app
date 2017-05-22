<?php

namespace RJ\PronosticApp\Util\Validation\Validator;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as V;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Util\Validation\General\ValidationResult;

class PlayerValidator extends AbstractValidator
{
    /**
     * Validate attributes from player.
     * @param \RJ\PronosticApp\Model\Entity\PlayerInterface $player
     * @return $this
     */
    public function validatePlayerData(PlayerInterface $player)
    {
        try {
            V::alnum()->length(3, 20)->assert($player->getNickname());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage($e->getFullMessage());
        }

        try {
            V::notBlank()->notOptional()->notEmpty()->assert($player->getPassword());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage($e->getFullMessage());
        }

        try {
            V::email()->assert($player->getEmail());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage($e->getFullMessage());
        }

        try {
            V::optional(V::alpha()->length(3, 60))->assert($player->getFirstName());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage($e->getFullMessage());
        }

        try {
            V::optional(V::alpha()->length(3, 100))->assert($player->getLastName());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage($e->getFullMessage());
        }

        try {
            V::hexRgbColor()->assert($player->getColor());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage(sprintf("Error validando el campo 'color': %s", $e->getFullMessage()));
        }
        
        return $this;
    }
}
