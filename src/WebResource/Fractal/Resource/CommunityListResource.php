<?php

namespace RJ\PronosticApp\WebResource\Fractal\Resource;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Resource only for display.
 */
class CommunityListResource
{
    /**
     * Actual date.
     * @var \DateTime
     */
    private $date;

    /**
     * Player
     * @var PlayerInterface
     */
    private $player;

    /**
     * List of communities
     * @var PlayerCommunityResource[]
     */
    private $communities = [];

    /**
     * @param PlayerInterface $player
     * @param CommunityInterface[] $communities
     */
    public function __construct(PlayerInterface $player, array $communities)
    {
        $this->date = new \DateTime();
        $this->player = $player;

        foreach ($communities as $community) {
            $this->communities[] = new PlayerCommunityResource($player, $community);
        }
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
     * @return PlayerInterface
     */
    public function getPlayer(): PlayerInterface
    {
        return $this->player;
    }

    /**
     * @param PlayerInterface $player
     */
    public function setPlayer(PlayerInterface $player)
    {
        $this->player = $player;
    }

    /**
     * @return PlayerCommunityResource[]
     */
    public function getPlayerCommunities()
    {
        return $this->communities;
    }
}
