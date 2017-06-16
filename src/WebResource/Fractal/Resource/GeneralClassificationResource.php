<?php

namespace RJ\PronosticApp\WebResource\Fractal\Resource;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;

/**
 * Resource only for display.
 */
class GeneralClassificationResource
{
    /**
     * Actual date.
     * @var \DateTime
     */
    private $date;

    /**
     * List of matches
     * @var CommunityInterface
     */
    private $community;

    /**
     * @var GeneralMatchdayClassificationResource[]
     */
    private $generaMatchdayClassifications;

    /**
     * GeneralClassificationResource constructor.
     *
     * @param CommunityInterface $community
     * @param MatchdayInterface[] $matchdays
     */
    public function __construct(CommunityInterface $community, array $matchdays)
    {
        $this->date = new \DateTime();
        $this->community = $community;
        $this->setMatchdays($matchdays);
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
     * @param MatchdayInterface[] $matchdays
     */
    public function setMatchdays(array $matchdays)
    {
        foreach ($matchdays as $matchday) {
            $this->generaMatchdayClassifications[] = new GeneralMatchdayClassificationResource(
                $this->getCommunity(),
                $matchday
            );
        }
    }

    /**
     * @return GeneralMatchdayClassificationResource[]
     */
    public function getGeneralMatchdayClassification(): array
    {
        return $this->generaMatchdayClassifications;
    }
}
