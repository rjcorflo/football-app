<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\GeneralclassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Repository for {@link GeneralclassificationInterface} entities.
 *
 * @method GeneralclassificationInterface create()
 * @method int store(GeneralclassificationInterface $classification)
 * @method int[] storeMultiple(array $classifications)
 * @method void trash(GeneralclassificationInterface $classification)
 * @method void trashMultiple(array $classifications)
 * @method GeneralclassificationInterface getById(int $idClassification)
 * @method GeneralclassificationInterface[] getMultipleById(array $idsClassifications)
 * @method GeneralclassificationInterface[] findAll()
 */
interface GeneralclassificationRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'generalclassification';

    /**
     * Find or create a new forecast.
     *
     * @param PlayerInterface $player
     * @param CommunityInterface $community
     * @param MatchdayInterface $matchday
     * @return GeneralclassificationInterface
     */
    public function findOneOrCreate(
        PlayerInterface $player,
        CommunityInterface $community,
        MatchdayInterface $matchday
    ): GeneralclassificationInterface;

    /**
     * Find classification for community.
     *
     * @param CommunityInterface $community
     * @return GeneralclassificationInterface[]
     */
    public function findByCommunity(CommunityInterface $community): array;

    /**
     * Find classifications for community only until next matchday (or actual).
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
     * @return GeneralclassificationInterface[]
     */
    public function findOrderedByMatchdayAndCommunity(
        MatchdayInterface $matchday,
        CommunityInterface $community
    ): array;

    /**
     * Return ids of matchdays with general classifications registers updated after date.
     *
     * @param CommunityInterface $community
     * @param \DateTime $date
     * @return array
     */
    public function findMatchdaysIdsWithGeneralClassificationUpdatedAfterDate(
        CommunityInterface $community,
        \DateTime $date = null
    ): array;
}
