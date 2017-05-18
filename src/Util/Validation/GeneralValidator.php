<?php

namespace RJ\PronosticApp\Util\Validation;

use RJ\PronosticApp\Util\Validation\Validator\CommunityValidator;
use RJ\PronosticApp\Util\Validation\Validator\ExistenceValidator;
use RJ\PronosticApp\Util\Validation\Validator\PlayerValidator;

class GeneralValidator implements ValidatorInterface
{
    private $playerValidator;

    private $communityValidator;

    private $existenceValidator;

    public function __construct(
        PlayerValidator $playerValidator,
        CommunityValidator $communityValidator,
        ExistenceValidator $existenceValidator
    ) {
        $this->playerValidator = $playerValidator;
        $this->communityValidator = $communityValidator;
        $this->existenceValidator = $existenceValidator;
    }

    public function playerValidator() : PlayerValidator
    {
        return $this->playerValidator;
    }

    public function communityValidator() : CommunityValidator
    {
        return $this->communityValidator;
    }

    public function existenceValidator() : ExistenceValidator
    {
        return $this->existenceValidator;
    }
}
