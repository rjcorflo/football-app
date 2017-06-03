<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RJ\PronosticApp\Model\Entity\TokenInterface;
use RJ\PronosticApp\Model\Repository\TokenRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Token;
use RedBeanPHP\R;
use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

/**
 * Class PlayerRepository
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
    public function findPlayerByNicknameOrEmail(string $player) : array
    {
        $players = R::find(self::ENTITY, '(nickname LIKE :name OR email LIKE :name)', [':name' => $player]);
        return RedBeanUtils::boxArray($players);
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
