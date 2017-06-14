<?php

namespace RJ\PronosticApp\Process;

use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ForecastRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchdayClassificationRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchdayRepositoryInterface;
use RJ\PronosticApp\Persistence\EntityManager;

/**
 * Class ClassificationCalculationProcess.
 *
 * Calculate classifications for all communities.
 *
 * @package RJ\PronosticApp\Process
 */
class ClassificationCalculationProcess
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @inheritDoc
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function launch(): void
    {
        /** @var CommunityRepositoryInterface $communityRepository */
        $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);

        /** @var MatchdayRepositoryInterface $matchdayRepository */
        $matchdayRepository = $this->entityManager->getRepository(MatchdayRepositoryInterface::class);

        /** @var ForecastRepositoryInterface $forecastRepository */
        $forecastRepository = $this->entityManager->getRepository(ForecastRepositoryInterface::class);

        /** @var MatchdayClassificationRepositoryInterface $matchdayClassRepo */
        $matchdayClassRepo = $this->entityManager->getRepository(MatchdayClassificationRepositoryInterface::class);

        $matchdays = $matchdayRepository->findAll();
        $communities = $communityRepository->findAll();

        foreach ($matchdays as $matchday) {
            foreach ($communities as $community) {
                $players = $community->getPlayers();

                foreach ($players as $player) {
                    $forecasts = $forecastRepository->findAllFromCommunity($community, $player, $matchday);

                    if (count($forecasts) === 0) {
                        continue;
                    }

                    $totalPoints = 0;
                    $hitsTen = 0;
                    $hitsFive = 0;
                    $hitsThree = 0;
                    $hitsTwo = 0;
                    $hitsOne = 0;
                    $hitsNegative = 0;

                    $beans = [];
                    foreach ($forecasts as $forecast) {
                        $forecast->calculateActualPoints();

                        $totalPoints += $forecast->getPoints();
                        $hitsTen += $forecast->getPoints() == 10 ? 1 : 0;
                        $hitsFive += $forecast->getPoints() == 5 ? 1 : 0;
                        $hitsThree += $forecast->getPoints() == 3 ? 1 : 0;
                        $hitsTwo += $forecast->getPoints() == 2 ? 1 : 0;
                        $hitsOne += $forecast->getPoints() == 1 ? 1 : 0;
                        $hitsNegative += $forecast->getPoints() == -1 ? 1 : 0;

                        $beans[] = $forecast;
                    }

                    $forecastRepository->storeMultiple($beans);

                    $classification = $matchdayClassRepo->findOneOrCreate($player, $community, $matchday);
                    $classification->setCommunity($community);
                    $classification->setPlayer($player);
                    $classification->setMatchday($matchday);
                    $classification->setTotalPoints($totalPoints);
                    $classification->setHitsTenPoints($hitsTen);
                    $classification->setHitsFivePoints($hitsFive);
                    $classification->setHitsThreePoints($hitsThree);
                    $classification->setHitsTwoPoints($hitsTwo);
                    $classification->setHitsOnePoints($hitsOne);
                    $classification->setHitsNegativePoints($hitsNegative);

                    $matchdayClassRepo->store($classification);
                }
            }
        }
    }
}
