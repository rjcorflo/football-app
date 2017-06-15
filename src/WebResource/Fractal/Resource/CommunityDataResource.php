<?php

namespace RJ\PronosticApp\WebResource\Fractal\Resource;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ForecastInterface;
use RJ\PronosticApp\Model\Entity\MatchdayclassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Resource for display.
 */
class CommunityDataResource
{
    /** @var CommunityInterface */
    private $community;

    /** @var \DateTime */
    private $date;

    /** @var PlayerInterface[] */
    private $players;

    /** @var MatchdayInterface[] */
    private $matchdays;

    /** @var  MatchInterface[] */
    private $matches;

    /** @var  ForecastInterface[] */
    private $forecasts;

    /** @var  MatchdayclassificationInterface[] */
    private $classification;

    /**
     * CommunityDataResource constructor.
     * @param CommunityInterface $community
     */
    public function __construct(CommunityInterface $community)
    {
        $this->community = $community;
        $this->date = new \DateTime();
    }

    /**
     * @return CommunityInterface
     */
    public function getCommunity(): CommunityInterface
    {
        return $this->community;
    }

    /**
     * @param CommunityInterface $community
     */
    public function setCommunity(CommunityInterface $community)
    {
        $this->community = $community;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return PlayerInterface[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @param PlayerInterface[] $players
     */
    public function setPlayers(array $players)
    {
        $this->players = $players;
    }

    /**
     * @return MatchdayInterface[]
     */
    public function getMatchdays(): array
    {
        return $this->matchdays;
    }

    /**
     * @param MatchdayInterface[] $matchdays
     */
    public function setMatchdays(array $matchdays)
    {
        $this->matchdays = $matchdays;
    }

    /**
     * @return MatchInterface[]
     */
    public function getMatches(): array
    {
        return $this->matches;
    }

    /**
     * @param MatchInterface[] $matches
     */
    public function setMatches(array $matches)
    {
        $this->matches = $matches;
    }

    /**
     * @return ForecastInterface[]
     */
    public function getForecasts(): array
    {
        return $this->forecasts;
    }

    /**
     * @param ForecastInterface[] $forecasts
     */
    public function setForecasts(array $forecasts)
    {
        $this->forecasts = $forecasts;
    }

    /**
     * @return MatchdayclassificationInterface[]
     */
    public function getClassification(): array
    {
        return $this->classification;
    }

    /**
     * @param MatchdayclassificationInterface[] $classification
     */
    public function setClassification(array $classification)
    {
        $this->classification = $classification;
    }
}
