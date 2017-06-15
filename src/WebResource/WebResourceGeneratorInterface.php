<?php

namespace RJ\PronosticApp\WebResource;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ForecastInterface;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Entity\MatchdayclassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;
use RJ\PronosticApp\Model\Entity\ParticipantInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Entity\TokenInterface;
use RJ\PronosticApp\Util\General\ForecastResult;
use RJ\PronosticApp\Util\General\MessageResult;

/**
 * Interface WebResourceGeneratorInterface.
 *
 * Creates web resource from entities.
 *
 * @package RJ\PronosticApp\WebResource
 */
interface WebResourceGeneratorInterface
{
    /**
     * Return type JSON.
     * @var string
     */
    const JSON = 'json';

    /**
     * Return type array
     * @var string
     */
    const ARRAY = 'array';

    /**
     * @param string $includes
     * @return $this
     */
    public function include(string $includes);

    /**
     * Exclude internal Resource
     *
     * @param string $excludes
     * @return $this
     */
    public function exclude(string $excludes);

    /**
     * @param MessageResult $messages
     * @param string $resultType
     * @return array|string
     */
    public function createMessageResource(MessageResult $messages, $resultType = self::JSON);

    /**
     * @param ForecastResult $messages
     * @param string $resultType
     * @return array|string
     */
    public function createForecastMessageResource(ForecastResult $messages, $resultType = self::JSON);

    /**
     * @param PlayerInterface|PlayerInterface[] $players
     * @param string $resultType
     * @return array|string
     */
    public function createPlayerResource($players, $resultType = self::JSON);

    /**
     * @param CommunityInterface|CommunityInterface[] $communities
     * @param string $resultType
     * @return array|string
     */
    public function createCommunityResource($communities, $resultType = self::JSON);

    /**
     * @param  CommunityInterface[] $communities
     * @param  string $resultType
     * @return array|string
     */
    public function createCommunityListResource($communities, $resultType = self::JSON);

    /**
     * @param CommunityInterface $community
     * @param PlayerInterface[] $players
     * @param MatchdayInterface[] $matchdays
     * @param MatchInterface[] $matches
     * @param ForecastInterface[] $forecasts
     * @param MatchdayclassificationInterface[] $classifications
     * @param string $resultType
     * @return mixed
     */
    public function createCommunityDataResource(
        $community,
        $players,
        $matchdays,
        $matches,
        $forecasts,
        $classifications,
        $resultType = self::JSON
    );

    /**
     * @param TokenInterface|TokenInterface[] $tokens
     * @param string $resultType
     * @return array|string
     */
    public function createTokenResource($tokens, $resultType = self::JSON);

    /**
     * @param ImageInterface|ImageInterface[] $images
     * @param string $resultType
     * @return array|string
     */
    public function createImageResource($images, $resultType = self::JSON);

    /**
     * @param MatchInterface[] $matches
     * @param string $resultType
     * @return mixed
     */
    public function createActiveMatchesResource($matches, $resultType = self::JSON);
}
