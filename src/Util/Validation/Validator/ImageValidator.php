<?php

namespace RJ\PronosticApp\Util\Validation\Validator;

use Respect\Validation\Exceptions\NestedValidationException;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use Respect\Validation\Validator as V;
use RJ\PronosticApp\Util\Validation\General\ValidationResult;

class ImageValidator extends AbstractValidator
{
    /**
     * ImageValidator constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param \RJ\PronosticApp\Model\Entity\ImageInterface $image
     * @return $this
     */
    public function validateImageData(ImageInterface $image)
    {
        try {
            V::url()->assert($image->getUrl());
        } catch (NestedValidationException $e) {
            $this->result->isError();
            $this->result->addMessage(sprintf("Error validando el campo 'url': %s", $e->getFullMessage()));
        }

        return $this;
    }
}
