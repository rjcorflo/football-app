<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\TokenInterface;
use RJ\PronosticApp\Model\Repository\TokenRepositoryInterface;

/**
 * Class TokenRepository
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 * @method TokenInterface create()
 * @method int store(TokenInterface $image)
 * @method int[] storeMultiple(array $images)
 * @method void trash(TokenInterface $image)
 * @method void trashMultiple(array $images)
 * @method TokenInterface getById(int $idImage)
 * @method TokenInterface getMultipleById(array $idsImages)
 * @method TokenInterface[] findAll()
 */
class TokenRepository extends AbstractRepository implements TokenRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findByTokenString(string $tokenString): TokenInterface
    {
        /**
         * @var SimpleModel[] $tokens
         */
        $tokens = R::find(self::ENTITY, ['token LIKE ?'], [$tokenString]);

        if (count($tokens) === 0) {
            throw new \Exception("El token no existe");
        }

        $token = array_shift($tokens);

        return $token->box();
    }
}
