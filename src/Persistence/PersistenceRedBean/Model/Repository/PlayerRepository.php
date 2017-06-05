<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\Exception\NotFoundException;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Model\Repository\TokenRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Player;
use RJ\PronosticApp\Util\General\ErrorCodes;

/**
 * Class PlayerRepository.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 */
class PlayerRepository extends AbstractRepository implements PlayerRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function checkNickameExists(string $nickname) : bool
    {
        return R::count(self::ENTITY, 'nickname LIKE ?', [$nickname]) > 0;
    }

    /**
     * @inheritdoc
     */
    public function checkEmailExists(string $email) : bool
    {
        return R::count(self::ENTITY, 'email LIKE ?', [$email]) > 0;
    }

    /**
     * @inheritDoc
     */
    public function findPlayerByNicknameOrEmail(string $player) : PlayerInterface
    {
        /** @var Player $player */
        $player = R::findOne(self::ENTITY, '(nickname LIKE :name OR email LIKE :name)', [':name' => $player]);

        if ($player === null) {
            $exception = new NotFoundException('Usuario no encontrado');
            $exception->addMessageWithCode(
                ErrorCodes::LOGIN_ERROR_INCORRECT_USERNAME,
                "Nombre o email incorrectos"
            );

            throw new $exception;
        }

        return $player->box();
    }

    /**
     * @inheritdoc
     */
    public function findPlayerByToken(string $token) : PlayerInterface
    {
        /** @var TokenRepositoryInterface $tokenRepository */
        $tokenRepository = $this->entityManager->getRepository(TokenRepositoryInterface::class);

        $token = $tokenRepository->findByTokenString($token);

        return $token->getPlayer();
    }
}
