<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ForecastInterface;
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
}
