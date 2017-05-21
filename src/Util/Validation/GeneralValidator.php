<?php

namespace RJ\PronosticApp\Util\Validation;

use RJ\PronosticApp\Util\Validation\Validator\BasicDataValidator;
use RJ\PronosticApp\Util\Validation\Validator\CommunityValidator;
use RJ\PronosticApp\Util\Validation\Validator\ExistenceValidator;
use RJ\PronosticApp\Util\Validation\Validator\ImageValidator;
use RJ\PronosticApp\Util\Validation\Validator\PlayerValidator;

class GeneralValidator implements ValidatorInterface
{
    private $playerValidator;

    private $communityValidator;

    private $existenceValidator;

    private $imageValidator;

    private $basicDataValidator;

    public function __construct(
        PlayerValidator $playerValidator,
        CommunityValidator $communityValidator,
        ExistenceValidator $existenceValidator,
        ImageValidator $imageValidator,
        BasicDataValidator $basicDataValidator
    ) {
        $this->playerValidator = $playerValidator;
        $this->communityValidator = $communityValidator;
        $this->existenceValidator = $existenceValidator;
        $this->imageValidator = $imageValidator;
        $this->basicDataValidator = $basicDataValidator;
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

    public function imageValidator() : ImageValidator
    {
        return $this->imageValidator;
    }

    public function basicValidator() : BasicDataValidator
    {
        return $this->basicDataValidator;
    }
}
