<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RJ\PronosticApp\Model\Entity\TokenInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Token;
use RedBeanPHP\R;
use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\PlayerRepositoryInterface;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;

/**
 * Class PlayerRepository
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 * @method PlayerInterface create()
 * @method int store(PlayerInterface $player)
 * @method int[] storeMultiple(array $players)
 * @method void trash(PlayerInterface $player)
 * @method void trashMultiple(array $players)
 * @method PlayerInterface getById(int $idPlayer)
 * @method PlayerInterface getMultipleById(array $idsPlayers)
 * @method PlayerInterface[] findAll()
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
    public function generateTokenForPlayer(PlayerInterface $player) : TokenInterface
    {
        /**
         * @var Token $token
         */
        $token = R::dispense('token');
        $token->token = bin2hex(random_bytes(20));

        $player->addToken($token->box());

        $this->store($player);

        return $token->box();
    }

    /**
     * @inheritdoc
     */
    public function findPlayerByToken(string $token) : PlayerInterface
    {
        /**
         * @var SimpleModel[] $tokens
         */
        $tokens = R::find('token', ['token LIKE ?'], [$token]);

        if (count($tokens) !== 1) {
            throw new \Exception("Error recuperando el usuario por el token");
        }

        $token = array_shift($tokens);

        return $token->player->box();
    }
}
