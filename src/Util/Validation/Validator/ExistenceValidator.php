<?php

namespace RJ\PronosticApp\Util\Validation\Validator;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ParticipantRepositoryInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;
use RJ\PronosticApp\Util\General\ErrorCodes;

/**
 * Validate data existence.
 *
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
     * Check if nickname of player is already in use.
     *
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
                    ErrorCodes::PLAYER_USERNAME_ALREADY_EXISTS,
                    "Ya existe un usuario con ese nickname."
                );
            }
        } catch (\Throwable $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::DEFAULT_ERROR,
                "Error comprobando la existencia del nickname."
            );
        }

        return $this;
    }

    /**
     * Check if email is already in use.
     *
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
                    ErrorCodes::PLAYER_EMAIL_ALREADY_EXISTS,
                    "Ya existe un usuario con ese email."
                );
            }
        } catch (\Throwable $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::DEFAULT_ERROR,
                "Error comprobando la existencia del email."
            );
        }

        return $this;
    }

    /**
     * Check if community name is already in use.
     *
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
                    ErrorCodes::COMMUNITY_NAME_ALREADY_EXISTS,
                    "Ya existe una comunidad con ese nombre."
                );
            }
        } catch (\Throwable $e) {
            $this->result->isError();
            $this->result->addMessageWithCode(
                ErrorCodes::DEFAULT_ERROR,
                "Error comprobando la existencia del nombre de la comunidad."
            );
        }

        return $this;
    }

    /**
     * Check if player is already a member from community.
     *
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
                    ErrorCodes::PLAYER_IS_ALREADY_MEMBER,
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
                ErrorCodes::DEFAULT_ERROR,
                "Error comprobando si el jugador ya participa en la comunidad pasada."
            );
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function validate(): void
    {
        if ($this->result->hasError()) {
            $this->result->setDescription("Error registro existente");
        }

        parent::validate();
    }
}
