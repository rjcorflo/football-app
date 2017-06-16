<?php

namespace RJ\PronosticApp\WebResource\Fractal\Resource;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;

/**
 * Resource only for display.
 */
class GeneralMatchdayClassificationResource
{
    /**
     * List of matches
     * @var CommunityInterface
     */
    private $community;

    /**
     * @var MatchdayInterface
     */
    private $matchday;

    /**
     * GeneralClassificationResource constructor.
     * @param CommunityInterface $community
     */
    public function __construct(CommunityInterface $community, MatchdayInterface $matchday)
    {
        $this->community = $community;
        $this->matchday = $matchday;
    }

    /**
     * @return CommunityInterface
     */
    public function getCommunity(): CommunityInterface
    {
        return $this->community;
    }

    /**
     * @return MatchdayInterface
     */
    public function getMatchday(): MatchdayInterface
    {
        return $this->matchday;
    }
}
