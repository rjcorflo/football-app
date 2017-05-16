<?php

namespace RJ\PronosticApp\Util\Validation;

use RJ\PronosticApp\Util\Validation\Validator\AbstractValidator;
use RJ\PronosticApp\Util\Validation\Validator\ExistenceValidator;
use RJ\PronosticApp\Util\Validation\Validator\PlayerValidator;

class GeneralValidator implements ValidatorInterface
{
    private $playerValidator;

    private $existenceValidator;

    public function __construct(
        PlayerValidator $playerValidator,
        ExistenceValidator $existenceValidator
    ) {
        $this->playerValidator = $playerValidator;
        $this->existenceValidator = $existenceValidator;
    }

    public function playerValidator() : PlayerValidator
    {
        return $this->playerValidator;
    }

    public function communityValidator() : AbstractValidator
    {
        // TODO: Implement communityValidator() method.
    }

    public function existenceValidator() : ExistenceValidator
    {
        return $this->existenceValidator();
    }
}
