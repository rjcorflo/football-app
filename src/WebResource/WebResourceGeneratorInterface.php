<?php

namespace RJ\PronosticApp\WebResource;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Util\MessageResult;

interface WebResourceGeneratorInterface
{
    public function createMessageResource(MessageResult $message);

    public function createPlayerItemResource(PlayerInterface $player);

    public function createPlayersCollectionResource(array $player);

    public function createCommunityItemResource(CommunityInterface $community);

    public function createCommunitiesCollectionResource(CommunityInterface $community);
}