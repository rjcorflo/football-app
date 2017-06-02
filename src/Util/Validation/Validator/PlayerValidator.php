<?php

namespace RJ\PronosticApp\Util\Validation\Validator;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as V;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Util\General\ErrorCodes;

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
            $this->result->addMessageWithCode(
                ErrorCodes::INVALID_PLAYER_USERNAME,
                $e->getFullMessage()
            );
        }

        try {
            V::notBlank()->notOptional()->notEmpty()->assert($player->getPassword());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::INVALID_PLAYER_PASSWORD,
                $e->getFullMessage()
            );
        }

        try {
            V::email()->assert($player->getEmail());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::INVALID_PLAYER_EMAIL,
                $e->getFullMessage()
            );
        }

        try {
            V::optional(V::alpha()->length(3, 60))->assert($player->getFirstName());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::INVALID_PLAYER_FIRSTNAME,
                $e->getFullMessage()
            );
        }

        try {
            V::optional(V::alpha()->length(3, 100))->assert($player->getLastName());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::INVALID_PLAYER_LASTNAME,
                $e->getFullMessage()
            );
        }

        try {
            V::intVal()->assert($player->getIdAvatar());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::INVALID_PLAYER_IDAVATAR,
                sprintf("Error validando el campo 'id_avatar': %s", $e->getFullMessage())
            );
        }

        try {
            V::hexRgbColor()->assert($player->getColor());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::INVALID_PLAYER_COLOR,
                sprintf("Error validando el campo 'color': %s", $e->getFullMessage())
            );
        }
        
        return $this;
    }
}
