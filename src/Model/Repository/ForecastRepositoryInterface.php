<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ForecastInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Repository for {@link ForecastInterface} entities.
 *
 * @method ForecastInterface create()
 * @method int store(ForecastInterface $forecast)
 * @method int[] storeMultiple(array $forecasts)
 * @method void trash(ForecastInterface $forecast)
 * @method void trashMultiple(array $forecasts)
 * @method ForecastInterface getById(int $idForecast)
 * @method ForecastInterface[] getMultipleById(array $idsForecasts)
 * @method ForecastInterface[] findAll()
 */
interface ForecastRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'forecast';

    /**
     * Find or create a new forecast.
     *
     * @param PlayerInterface $player
     * @param CommunityInterface $community
     * @param MatchInterface $match
     * @return ForecastInterface
     */
    public function findOneOrCreate(
        PlayerInterface $player,
        CommunityInterface $community,
        MatchInterface $match
    ): ForecastInterface;

    /**
     * Find all forecasts from community.
     *
     * @param CommunityInterface $community
     * @param PlayerInterface $player
     * @param MatchdayInterface $matchday
     * @return ForecastInterface[]
     */
    public function findAllFromCommunity(
        CommunityInterface $community,
        PlayerInterface $player,
        MatchdayInterface $matchday
    ): array;

    /**
     * Find forecasts for community.
     *
     * @param CommunityInterface $community
     * @return ForecastInterface[]
     */
    public function findByCommunity(CommunityInterface $community): array;
}
