<?php

namespace RJ\PronosticApp\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RJ\PronosticApp\Model\Exception\Request\MissingParametersException;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\ForecastRepositoryInterface;
use RJ\PronosticApp\Model\Repository\MatchRepositoryInterface;
use RJ\PronosticApp\Util\General\ErrorCodes;
use RJ\PronosticApp\Util\General\ForecastResult;

/**
 * Class ForecastController.
 *
 * Expose operations to update player forecast.
 *
 * @package RJ\PronosticApp\Controller
 */
class ForecastController extends BaseController
{
    /**
     * Save forecasts from user.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function saveForecasts(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $idCommunity
    ): ResponseInterface {
        $bodyData = $request->getParsedBody();

        $result = new ForecastResult();

        $player = $request->getAttribute('player');

        /** @var CommunityRepositoryInterface $communityRepository */
        $communityRepository = $this->entityManager->getRepository(CommunityRepositoryInterface::class);
        $community = $communityRepository->getById($idCommunity);

        /** @var ForecastRepositoryInterface $forecastRepository */
        $forecastRepository = $this->entityManager->getRepository(ForecastRepositoryInterface::class);

        /** @var MatchRepositoryInterface $matchRepository */
        $matchRepository = $this->entityManager->getRepository(MatchRepositoryInterface::class);

        $this->entityManager->beginTransaction();
        try {
            if (!isset($bodyData['pronosticos'])) {
                $exception = new MissingParametersException();
                $exception->addMessageWithCode(
                    ErrorCodes::MISSING_PARAMETERS,
                    'El parámetro ["pronosticos"] es obligatorio'
                );

                throw $exception;
            }

            $forecasts = $bodyData['pronosticos'];

            foreach ($forecasts as $forecastData) {
                try {
                    // Check valid data or throw exception
                    $this->checkForecastValidity($forecastData);

                    $match = $matchRepository->getById($forecastData['id_partido']);

                    $actualDate = new \DateTime();
                    if ($actualDate > $match->getStartTime()) {
                        throw new \Exception('El partido y ha empezado.');
                    }

                    $result->setMatchdayId($match->getMatchday()->getId());

                    $forecast = $forecastRepository->findOneOrCreate($player, $community, $match);

                    if ($forecast->getId() === 0) {
                        $forecast->setPlayer($player);
                        $forecast->setCommunity($community);
                        $forecast->setMatch($match);
                    }

                    $forecast->setLocalGoals($forecastData['goles_local']);
                    $forecast->setAwayGoals($forecastData['goles_visitante']);
                    $forecast->setRisk((bool)$forecastData['riesgo']);
                    $forecast->setLastModifiedDate(new \DateTime());

                    $forecastRepository->store($forecast);

                    $result->addCorrect(
                        $match->getId(),
                        $forecast->getLocalGoals(),
                        $forecast->getAwayGoals(),
                        $forecast->isRisk()
                    );
                } catch (\Exception $e) {
                    $result->addError($forecastData['id_partido'] ?? 0, $e->getMessage());
                }
            }

            $resource = $this->resourceGenerator->createForecastMessageResource($result);

            $response = $this->generateJsonCorrectResponse($response, $resource);
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            $response = $this->generateJsonErrorResponse($response, $e);
        }

        return $response;
    }

    /**
     * @param $forecast
     * @throws \Exception
     */
    private function checkForecastValidity($forecast): void
    {
        $isValid = isset($forecast['id_partido']) && isset($forecast['goles_local'])
            && isset($forecast['goles_visitante']) && isset($forecast['riesgo']);

        if (!$isValid) {
            throw new \Exception('Faltan parámetros en algún pronóstico');
        }
    }
}
