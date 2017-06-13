<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\ForecastInterface;

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
}
