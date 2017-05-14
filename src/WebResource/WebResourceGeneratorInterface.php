<?php

namespace WebResource;

use RJ\FootballApp\Model\Entity\CommunityInterface;
use RJ\FootballApp\Model\Entity\PlayerInterface;
use Util\MessageResult;

interface WebResourceGeneratorInterface
{
    public function createMessageResource(MessageResult $message);

    public function createPlayerItemResource(PlayerInterface $player);

    public function createPlayersCollectionResource(array $player);

    public function createCommunityItemResource(CommunityInterface $community);

    public function createCommunitiesCollectionResource(CommunityInterface $community);
}