<?php

namespace USaq\Service;

use Doctrine\ORM\EntityManager;
use USaq\Model\Entity\Token;
use USaq\Model\Entity\User;
use USaq\Model\Exception\AlreadyExistsException;
use USaq\Model\Exception\EntityNotFoundException;
use USaq\Service\Exception\AuthenticationException;

/**
 * Provide operations to authenticate an user.
 *
 * @package USaq\Service
 */
class AuthenticationService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * AuthenticationService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Create new user in application.
     *
     * @param string $username          Username.
     * @param string $password          Password.
     * @throws AlreadyExistsException   If there is already an user with the same username.
     */
    public function createUser(string $username, string $password)
    {
        if ($this->checkIfUsernameExists($username)) {
            throw new AlreadyExistsException(sprintf('There is already an User with the username %s', $username));
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $user = new User($username, $passwordHash);

        $this->em->persist($user);

        $this->em->flush();
    }

    /**
     * Checks if user exists and if credentials are correct.
     *
     * @param string $username          Username.
     * @param string $password          Password.
     * @return Token                    Token resource.
     * @throws AuthenticationException  If user cannot be authenticated.
     */
    public function loginUser(string $username, string $password): Token
    {
        $userRepository = $this->em->getRepository('USaq\Model\Entity\User');

        /** @var User $user */
        $user = $userRepository->findOneBy(['username' => $username]);

        if (!$user || !password_verify($password, $user->getPassword())) {
            throw new AuthenticationException('Incorrect username or password');
        }

        $token = new Token();
        $token->setUser($user);
        $token->setExpireAt(new \DateTime('now + 15 days'));
        $token->generateRandomToken();

        $this->em->persist($token);
        $this->em->flush();

        return $token;
    }

    /**
     * Get user via token.
     *
     * @param string $tokenString       Token string.
     * @return User                     User identified by token string.
     * @throws EntityNotFoundException  If no user is found by this token.
     */
    public function retrieveUserByToken(string $tokenString): User
    {
        $tokenRepository = $this->em->getRepository('USaq\Model\Entity\Token');

        /** @var Token $token */
        $token = $tokenRepository->findOneBy(['tokenString' => $tokenString]);

        if (!$token) {
            throw new EntityNotFoundException('Token not found');
        }

        // Each time a token is retrieved update expiration date
        $token->setExpireAt(new \DateTime('now + 15 days'));

        return $token->getUser();
    }

    public function logoutUser(string $tokenString): bool
    {
        $logoutCorrect = true;

        try {
            /** @var Token $token */
            $token = $this->em->getRepository('USaq\Model\Entity\Token')->findOneBy(['tokenString' => $tokenString]);

            if (!$token) {
                throw new EntityNotFoundException('Token not found');
            }

            // Each time a token is retrieved update expiration date
            $this->em->remove($token);
            $this->em->flush();
        } catch (\Exception $e) {
            $logoutCorrect = false;
        }

        return $logoutCorrect;
    }

    public function checkIfUsernameExists(string $username): bool
    {
        $user = $this->em->getRepository('USaq\Model\Entity\User')->findOneBy(['username' => $username]);

        return (bool) $user;
    }
}
