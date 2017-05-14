<?php
/**
 * Created by PhpStorm.
 * User: RJ Corchero
 * Date: 13/05/2017
 * Time: 13:02
 */

namespace WebResource\Fractal;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use RJ\FootballApp\Model\Entity\CommunityInterface;
use RJ\FootballApp\Model\Entity\PlayerInterface;
use Util\MessageResult;
use WebResource\Fractal\Transformer\MessageResultTransformer;
use WebResource\WebResourceGeneratorInterface;

class FractalGenerator implements WebResourceGeneratorInterface
{
    private $manager;

    public function __construct()
    {
        $this->manager = new Manager();
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