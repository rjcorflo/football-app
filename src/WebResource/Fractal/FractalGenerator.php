<?php

namespace RJ\PronosticApp\WebResource\Fractal;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Util\MessageResult;
use RJ\PronosticApp\WebResource\Fractal\Transformer\MessageResultTransformer;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

class FractalGenerator implements WebResourceGeneratorInterface
{
    private $manager;

    public function __construct()
    {
        $this->manager = new Manager();
        $this->manager->setSerializer(new ArraySerializer());
    }

    public function createMessageResource(MessageResult $message)
    {
        $resource = new Item($message, new MessageResultTransformer());
        return $this->manager->createData($resource)->toJson();
    }

    public function createPlayerItemResource(PlayerInterface $player)
    {
        // TODO: Implement createPlayerItemResource() method.
    }

    public function createPlayersCollectionResource(array $player)
    {
        // TODO: Implement createPlayersCollectionResource() method.
    }

    public function createCommunityItemResource(CommunityInterface $community)
    {
        // TODO: Implement createCommunityItemResource() method.
    }

    public function createCommunitiesCollectionResource(CommunityInterface $community)
    {
        // TODO: Implement createCommunitiesCollectionResource() method.
    }

}