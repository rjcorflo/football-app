<?php

namespace RJ\PronosticApp\Util\Validation\Validator;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as V;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Util\Validation\General\ValidationResult;

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
            V::alnum()->length(3, 20)->assert($community->getCommunityName());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage($e->getFullMessage());
        }

        if ($community->isPrivate()) {
            try {
                V::notBlank()->notOptional()->notEmpty()->assert($community->getPassword());
            } catch (NestedValidationException $e) {
                $this->result->isError();
                $this->result->addMessage($e->getFullMessage());
            }
        }
        
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function validate() : ValidationResult
    {
        return $this->result;
    }
}
