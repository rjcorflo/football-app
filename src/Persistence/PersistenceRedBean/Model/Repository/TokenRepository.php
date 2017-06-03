<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\TokenInterface;
use RJ\PronosticApp\Model\Repository\TokenRepositoryInterface;

/**
 * Class TokenRepository
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 */
class TokenRepository extends AbstractRepository implements TokenRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function createRandomToken(): TokenInterface
    {
        $token = $this->create();
        $token->generateRandomToken();

        return $token;
    }

    /**
     * @inheritDoc
     */
    public function findByTokenString(string $tokenString): TokenInterface
    {
        /**
         * @var SimpleModel[] $tokens
         */
        $tokens = R::find(self::ENTITY, ['token LIKE ?'], [$tokenString]);

        $numberOfTokens = count($tokens);

        if ($numberOfTokens === 0) {
            throw new \Exception('El token no existe');
        } elseif ($numberOfTokens > 1) {
            throw new \Exception('Error: se han recuperado varios tokens para la misma cadena');
        }

        $token = array_shift($tokens);

        return $token->box();
    }
}
