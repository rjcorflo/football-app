<?php

namespace RJ\PronosticApp\Util\Validation\Validator;

use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Util\Validation\General\ValidationResult;

class ExistenceValidator extends AbstractValidator
{
    /**
     * @var \RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface
     */
    private $playerRepository;

    /**
     * ExistenceValidator constructor.
     * @param \RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface $playerRepository
     */
    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        parent::__construct();
        $this->playerRepository = $playerRepository;
    }

    /**
     * @param \RJ\PronosticApp\Model\Entity\PlayerInterface $player
     * @return $this
     */
    public function checkIfNicknameExists(PlayerInterface $player)
    {
        try {
            $existsNickname = $this->playerRepository->checkNickameExists($player->getNickname());

            if ($existsNickname) {
                $this->result->isError();
                $this->result->addMessage("Ya existe un usuario con ese nickname.");
            }
        } catch (\Throwable $e) {
            $this->result->isError();
            $this->result->addMessage("Error comprobando la existencia del nickname.");
        }

        return $this;
    }

    /**
     * @param \RJ\PronosticApp\Model\Entity\PlayerInterface $player
     * @return $this
     */
    public function checkIfEmailExists(PlayerInterface $player)
    {
        try {
            $existsEmail = $this->playerRepository->checkEmailExists($player->getEmail());

            if ($existsEmail) {
                $this->result->isError();
                $this->result->addMessage("Ya existe un usuario con ese email.");
            }
        } catch (\Throwable $e) {
            $this->result->isError();
            $this->result->addMessage("Error comprobando la existencia del email.");
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function validate() : ValidationResult
    {
        if ($this->result->hasError()) {
            $this->result->setDescription("Ya existe un usuario con ese nickname o email.");
        }

        return $this->result;
    }
}
