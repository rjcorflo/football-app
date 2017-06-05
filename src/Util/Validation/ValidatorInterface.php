<?php

namespace RJ\PronosticApp\Util\Validation;

use RJ\PronosticApp\Util\Validation\Validator\BasicDataValidator;
use RJ\PronosticApp\Util\Validation\Validator\CommunityValidator;
use RJ\PronosticApp\Util\Validation\Validator\ExistenceValidator;
use RJ\PronosticApp\Util\Validation\Validator\PlayerValidator;

/**
 * Interface ValidatorInterface.
 *
 * Group validators.
 *
 * @package RJ\PronosticApp\Util\Validation
 */
interface ValidatorInterface
{
    /**
     * @return PlayerValidator
     */
    public function playerValidator() : PlayerValidator;

    /**
     * @return CommunityValidator
     */
    public function communityValidator() : CommunityValidator;

    /**
     * @return ExistenceValidator
     */
    public function existenceValidator() : ExistenceValidator;

    /**
     * @return BasicDataValidator
     */
    public function basicValidator() : BasicDataValidator;
}
