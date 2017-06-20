<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;

/**
 * Repository for {@link MatchdayInterface} entities.
 *
 * @method MatchdayInterface create()
 * @method int store(MatchdayInterface $matchday)
 * @method int[] storeMultiple(array $matchdays)
 * @method void trash(MatchdayInterface $matchday)
 * @method void trashMultiple(array $matchdays)
 * @method MatchdayInterface getById(int $idMatchday)
 * @method MatchdayInterface[] getMultipleById(array $idsMatchdays)
 * @method MatchdayInterface[] findAll()
 */
interface MatchdayRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'matchday';

    /**
     * Get next or actual matchday.
     *
     * @return null|MatchdayInterface
     */
    public function getNextMatchday(): ?MatchdayInterface;

    /**
     * Get last completed matchday.
     *
     * @return MatchdayInterface
     */
    public function getLastMatchday(): MatchdayInterface;

    /**
     * Find all matchdays until next matchday (included).
     *
     * If next (or actual) matchday is Jornada 3, returns Jornada 3 and all before it.
     *
     * @return MatchdayInterface[]
     */
    public function findAllUntilNextMatchday(): array;

    /**
     * Return all matchdays ordered by matchday_order field.
     *
     * @return MatchdayInterface[]
     */
    public function findAllOrdered(): array;

    /**
     * Find matchdays for community updated after date (or all if no date is passed).
     *
     * @param CommunityInterface $community
     * @param \DateTime|null $date
     * @return MatchdayInterface[]
     */
    public function findByCommunity(CommunityInterface $community, \DateTime $date = null): array;

    /**
     * Retrieve all matchdays between two of them.
     *
     * Example: Return Jornada 2, Jornada 3 y Jornada 4 when passed Jornada 2 and Jornada 4 as parameters
     *
     * @param MatchdayInterface $initial
     * @param MatchdayInterface $finish
     * @return mixed
     */
    public function findAllBetweenMatchdays(MatchdayInterface $initial, MatchdayInterface $finish);
}
