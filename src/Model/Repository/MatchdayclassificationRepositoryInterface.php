<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\MatchdayclassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Repository for {@link MatchdayclassificationInterface} entities.
 *
 * @method MatchdayclassificationInterface create()
 * @method int store(MatchdayclassificationInterface $classification)
 * @method int[] storeMultiple(array $classifications)
 * @method void trash(MatchdayclassificationInterface $classification)
 * @method void trashMultiple(array $classifications)
 * @method MatchdayclassificationInterface getById(int $idClassification)
 * @method MatchdayclassificationInterface[] getMultipleById(array $idsClassifications)
 * @method MatchdayclassificationInterface[] findAll()
 */
interface MatchdayclassificationRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'matchdayclassification';

    /**
     * Find or create a new forecast.
     *
     * @param PlayerInterface $player
     * @param CommunityInterface $community
     * @param MatchdayInterface $matchday
     * @return MatchdayclassificationInterface
     */
    public function findOneOrCreate(
        PlayerInterface $player,
        CommunityInterface $community,
        MatchdayInterface $matchday
    ): MatchdayclassificationInterface;

    /**
     * Find classification for community.
     *
     * @param CommunityInterface $community
     * @return MatchdayclassificationInterface[]
     */
    public function findByCommunity(CommunityInterface $community): array;

    /**
     * Find classifications for community only after next matchday (or actual).
     * If a date is passed, only modified records after that date are returned.
     *
     * @param CommunityInterface $community
     * @param MatchdayInterface $nextMatchday
     * @param \DateTime|null $date
     * @return array
     */
    public function findByCommunityUntilNextMatchdayModifiedAfterDate(
        CommunityInterface $community,
        MatchdayInterface $nextMatchday,
        \DateTime $date = null
    ): array;

    /**
     * Return classification for one community and one matchday.
     *
     * @param MatchdayInterface $matchday
     * @param CommunityInterface $community
     * @return MatchdayclassificationInterface[]
     */
    public function findOrderedByMatchdayAndCommunity(
        MatchdayInterface $matchday,
        CommunityInterface $community
    ): array;
}
