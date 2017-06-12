<?php

namespace RJ\PronosticApp\WebResource\Fractal\Resource;

use RJ\PronosticApp\Model\Entity\CommunityInterface;

/**
 * Rsource only for display.
 */
class CommunityListResource
{
    /**
     * Actual date.
     * @var \DateTime
     */
    private $date;

    /**
     * List of communities
     * @var CommunityInterface[]
     */
    private $communities;

    /**
     * @param CommunityInterface[] $communities
     */
    public function __construct(array $communities)
    {
        $this->date = new \DateTime();
        $this->communities = $communities;
    }

    /**
     * @param \DateTime $date Actual date.
     */
    public function setActualDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return \DateTime
     */
    public function getActualDate()
    {
        return $this->date;
    }

    /**
     * @param CommunityInterface[] $communities
     */
    public function setCommunities(array $communities)
    {
        $this->communities = $communities;
    }

    /**
     * @return CommunityInterface[]
     */
    public function getCommunities()
    {
        return $this->communities;
    }
}
