<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\MatchdayClassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Repository for {@link MatchdayClassificationInterface} entities.
 *
 * @method MatchdayClassificationInterface create()
 * @method int store(MatchdayClassificationInterface $classification)
 * @method int[] storeMultiple(array $classifications)
 * @method void trash(MatchdayClassificationInterface $classification)
 * @method void trashMultiple(array $classifications)
 * @method MatchdayClassificationInterface getById(int $idClassification)
 * @method MatchdayClassificationInterface[] getMultipleById(array $idsClassifications)
 * @method MatchdayClassificationInterface[] findAll()
 */
interface MatchdayClassificationRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'matchdayclassification';

    /**
     * Find or create a new forecast.
     *
     * @param PlayerInterface $player
     * @param CommunityInterface $community
     * @param MatchdayInterface $matchday
     * @return MatchdayClassificationInterface
     */
    public function findOneOrCreate(
        PlayerInterface $player,
        CommunityInterface $community,
        MatchdayInterface $matchday
    ): MatchdayClassificationInterface;

    /**
     * Find classification for community.
     *
     * @param CommunityInterface $community
     * @return MatchdayClassificationInterface[]
     */
    public function findByCommunity(CommunityInterface $community): array;
}
