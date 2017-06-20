<?php

namespace RJ\PronosticApp\WebResource\Fractal\Resource;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Class PlayerCommunityResource
 * @package RJ\PronosticApp\WebResource\Fractal\Resource
 */
class PlayerCommunityResource
{
    private $player;

    private $community;

    public function __construct(PlayerInterface $player, CommunityInterface $community)
    {
        $this->player = $player;
        $this->community = $community;
    }

    /**
     * @return PlayerInterface
     */
    public function getPlayer(): PlayerInterface
    {
        return $this->player;
    }

    /**
     * @return CommunityInterface
     */
    public function getCommunity(): CommunityInterface
    {
        return $this->community;
    }
}
