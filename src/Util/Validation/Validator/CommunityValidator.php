<?php

namespace RJ\PronosticApp\Util\Validation\Validator;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as V;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Util\General\ErrorCodes;

/**
 * Validate data from community.
 *
 * @package RJ\PronosticApp\Util\Validation\Validator
 */
class CommunityValidator extends AbstractValidator
{
    /**
     * Validate attributes from player.
     * @param \RJ\PronosticApp\Model\Entity\CommunityInterface $community
     * @return $this
     */
    public function validateCommunityData(CommunityInterface $community)
    {
        try {
            V::alnum()->length(4, 20)->assert($community->getCommunityName());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::INVALID_COMMUNITY_NAME,
                sprintf("Error validando el campo 'nombre': %s", $e->getFullMessage())
            );
        }

        if ($community->isPrivate()) {
            try {
                V::notBlank()->notOptional()->notEmpty()->assert($community->getPassword());
            } catch (NestedValidationException $e) {
                $this->result->isError();
                $this->result->addMessageWithCode(
                    ErrorCodes::INVALID_COMMUNITY_PASSWORD,
                    sprintf("Error validando el campo 'password': %s", $e->getFullMessage())
                );
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function validate(): void
    {
        if ($this->result->hasError()) {
            $this->result->setDescription('Error validando los datos de la comunidad');
        }

        parent::validate();
    }
}
