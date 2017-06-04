<?php

namespace RJ\PronosticApp\Util\Validation\Validator;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Util\General\ErrorCodes;
use RJ\PronosticApp\Util\Validation\General\ValidationResult;

/**
 * Class ExistenceValidator
 * @package RJ\PronosticApp\Util\Validation\Validator
 */
class ExistenceValidator extends AbstractValidator
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ExistenceValidator constructor.
     * @param EntityManager $enityManager
     */
    public function __construct(
        EntityManager $enityManager
    ) {
        parent::__construct();
        $this->entityManager = $enityManager;
    }

    /**
     * @param \RJ\PronosticApp\Model\Entity\PlayerInterface $player
     * @return $this
     */
    public function checkIfNicknameExists(PlayerInterface $player)
    {
        /** @var PlayerRepositoryInterface $playerRepository */
        $playerRepository = $this->entityManager->getRepository(PlayerRepositoryInterface::class);

        try {
            $existsNickname = $playerRepository->checkNickameExists($player->getNickname());

            if ($existsNickname) {
                $this->result->isError();
                $this->result->addMessageWithCode(
                    ErrorCodes::EXIST_PLAYER_USERNAME,
                    "Ya existe un usuario con ese nickname."
                );
            }
        } catch (\Throwable $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::DEFAULT,
                "Error comprobando la existencia del nickname."
            );
        }

        return $this;
    }

    /**
     * @param \RJ\PronosticApp\Model\Entity\PlayerInterface $player
     * @return $this
     */
    public function checkIfEmailExists(PlayerInterface $player)
    {
        /** @var PlayerRepositoryInterface $playerRepository */
        $playerRepository = $this->entityManager->getRepository(PlayerRepositoryInterface::class);

        try {
            $existsEmail = $playerRepository->checkEmailExists($player->getEmail());

            if ($existsEmail) {
                $this->result->isError();
                $this->result->addMessageWithCode(
                    ErrorCodes::EXIST_PLAYER_EMAIL,
                    "Ya existe un usuario con ese email."
                );
            }
        } catch (\Throwable $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::DEFAULT,
                "Error comprobando la existencia del email."
            );
        }

        return $this;
    }

    /**
     * @param \RJ\PronosticApp\Model\Entity\CommunityInterface $community
     * @return $this
     */
    public function checkIfNameExists(CommunityInterface $community)
    {
        /** @var CommunityRepositoryInterface $communityRepository */
        $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

        try {
            $existsName = $communityRepository->checkIfNameExists($community->getCommunityName());

            if ($existsName) {
                $this->result->isError();
                $this->result->addMessageWithCode(
                    ErrorCodes::EXIST_COMMUNITY_NAME,
                    "Ya existe una comunidad con ese nombre."
                );
            }
        } catch (\Throwable $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::DEFAULT,
                "Error comprobando la existencia del nombre de la comunidad."
            );
        }

        return $this;
    }

    /**
     * @param PlayerInterface $player
     * @param CommunityInterface $community
     * @return $this
     */
    public function checkIfPlayerIsAlreadyFromCommunity(PlayerInterface $player, CommunityInterface $community)
    {
        /** @var ParticipantRepositoryInterface $participantRepo */
        $participantRepo = $this->entityManager->getRepository(ParticipantRepositoryInterface::class);

        try {
            $exists = $participantRepo->checkIfPlayerIsAlreadyFromCommunity($player, $community);

            if ($exists) {
                $this->result->isError();
                $this->result->addMessageWithCode(
                    ErrorCodes::EXIST_COMMUNITY_NAME,
                    sprintf(
                        'El jugador %s ya es miembro de la comunidad %s.',
                        $player->getNickname(),
                        $community->getCommunityName()
                    )
                );
            }
        } catch (\Throwable $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::DEFAULT,
                "Error comprobando si el jugador ya participa en la comunidad pasada."
            );
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function validate(): ValidationResult
    {
        if ($this->result->hasError()) {
            $this->result->setDescription("Error registro existente.");
        }

        return $this->result;
    }
}
