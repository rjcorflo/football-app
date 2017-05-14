<?php

namespace RJ\PronosticApp\Model\Validator;

use RJ\PronosticApp\Model\Entity\PlayerInterface;

class PlayerValidator extends AbstractValidator
{
    private $player;

    public function __construct(PlayerInterface $player)
    {
        $this->player = $player;
    }

    public function validate() : ValidationResult
    {

    }

}