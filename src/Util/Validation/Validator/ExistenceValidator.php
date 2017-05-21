<?php

namespace RJ\PronosticApp\Util\Validation\Validator;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Util\Validation\General\ValidationResult;

class ExistenceValidator extends AbstractValidator
{
    /**
     * @var \RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface
     */
    private $playerRepository;

    /**
     * @var \RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface
     */
    private $communityRepository;

    /**
     * ExistenceValidator constructor.
     * @param \RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface $playerRepository
     * @param \RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface $communityRepository
     */
    public function __construct(
        PlayerRepositoryInterface $playerRepository,
        CommunityRepositoryInterface $communityRepository
    ) {
        parent::__construct();
        $this->playerRepository = $playerRepository;
        $this->communityRepository = $communityRepository;
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
     * @param \RJ\PronosticApp\Model\Entity\CommunityInterface $community
     * @return $this
     */
    public function checkIfNameExists(CommunityInterface $community)
    {
        try {
            $existsName = $this->communityRepository->checkIfNameExists($community->getCommunityName());

            if ($existsName) {
                $this->result->isError();
                $this->result->addMessage("Ya existe una comunidad con ese nombre.");
            }
        } catch (\Throwable $e) {
            $this->result->isError();
            $this->result->addMessage("Error comprobando la existencia del nombre de la comunidad.");
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
