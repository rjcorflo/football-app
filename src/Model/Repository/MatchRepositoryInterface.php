<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;

/**
 * Repository for {@link MatchInterface} entities.
 *
 * @method MatchInterface create()
 * @method int store(MatchInterface $match)
 * @method int[] storeMultiple(array $matches)
 * @method void trash(MatchInterface $match)
 * @method void trashMultiple(array $matches)
 * @method MatchInterface getById(int $idMatch)
 * @method MatchInterface[] getMultipleById(array $idsMatches)
 * @method MatchInterface[] findAll()
 */
interface MatchRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'match';

    /**
     * Find matches by matchday with start date after actual date.
     *
     * @param int $idMatchday
     * @return MatchInterface[]
     */
    public function findActivesByMatchday(int $idMatchday): array;

    /**
     * Find matches for community updated after date (or all if no date is passed).
     *
     * @param CommunityInterface $community
     * @param \DateTime|null $date
     * @return MatchInterface[]
     */
    public function findByCommunity(CommunityInterface $community, \DateTime $date = null): array;
}
