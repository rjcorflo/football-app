<?php

namespace RJ\PronosticApp\WebResource\Fractal\Resource;

use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\MatchInterface;

/**
 * Resource only for display.
 */
class MatchListResource
{
    /**
     * Actual date.
     * @var \DateTime
     */
    private $date;

    /**
     * List of matches
     * @var MatchdayInterface[]
     */
    private $matches;

    /**
     * @param MatchInterface[] $matches
     */
    public function __construct(array $matches)
    {
        $this->date = new \DateTime();
        $this->matches = $matches;
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
     * @param MatchInterface[] $matches
     */
    public function setMatches(array $matches)
    {
        $this->matches = $matches;
    }

    /**
     * @return MatchInterface[]
     */
    public function getMatches()
    {
        return $this->matches;
    }
}
