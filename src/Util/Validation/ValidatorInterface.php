<?php

namespace RJ\PronosticApp\Util\Validation;

use RJ\PronosticApp\Util\Validation\Validator\BasicDataValidator;
use RJ\PronosticApp\Util\Validation\Validator\CommunityValidator;
use RJ\PronosticApp\Util\Validation\Validator\ExistenceValidator;
use RJ\PronosticApp\Util\Validation\Validator\ImageValidator;
use RJ\PronosticApp\Util\Validation\Validator\PlayerValidator;

interface ValidatorInterface
{
    public function playerValidator() : PlayerValidator;

    public function communityValidator() : CommunityValidator;

    public function existenceValidator() : ExistenceValidator;

    public function imageValidator() : ImageValidator;

    public function basicValidator() : BasicDataValidator;
}
