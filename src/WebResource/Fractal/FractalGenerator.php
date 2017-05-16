<?php

namespace RJ\PronosticApp\WebResource\Fractal;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Scope;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Entity\TokenInterface;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\WebResource\Fractal\Serializer\NoDataArraySerializer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\CommunityTransformer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\MessageResultTransformer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\PlayerTransformer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\TokenTransformer;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

class FractalGenerator implements WebResourceGeneratorInterface
{
    private $manager;

    /**
     * FractalGenerator constructor.
     * @param \League\Fractal\Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
        $this->manager->setSerializer(new NoDataArraySerializer());
    }

    /**
     * @inheritdoc
     */
    public function createMessageResource(
        MessageResult $message,
        $resultType = self::JSON
    ) {
        $resource = new Item($message, new MessageResultTransformer());
        return $this->returnResourceType($this->manager->createData($resource), $resultType);
    }

    /**
     * @inheritdoc
     */
    public function createPlayerResource($player, $resultType = self::JSON)
    {
        if ($player instanceof PlayerInterface) {
            $resource = new Item($player, new PlayerTransformer());
        } elseif (is_array($player)) {
            $resource = new Collection($player, new PlayerTransformer());
        } else {
            throw new \Exception("El recurso pasado no es un instancia que implemente " .
                "PlayerInterface o sea un array PlayerInterface[]");
        }

        return $this->returnResourceType($this->manager->createData($resource), $resultType);
    }

    /**
     * @inheritdoc
     */
    public function createCommunityResource(
        $community,
        $resultType = self::JSON
    ) {
        if ($community instanceof CommunityInterface) {
            $resource = new Item($community, new CommunityTransformer());
        } elseif (is_array($community)) {
            $resource = new Collection($community, new CommunityTransformer());
        } else {
            throw new \Exception("El recurso pasado no es un instancia que implemente " .
                "CommunityInterface o sea un array CommunityInterface[]");
        }

        return $this->returnResourceType($this->manager->createData($resource), $resultType);
    }

    /**
     * @inheritdoc
     */
    public function createTokenResource($token, $resultType = self::JSON)
    {
        if ($token instanceof TokenInterface) {
            $resource = new Item($token, new TokenTransformer());
        } elseif (is_array($token)) {
            $resource = new Collection($token, new TokenTransformer());
        } else {
            throw new \Exception("El recurso pasado no es un instancia que implemente " .
                "TokenInterface o sea un array TokenInterface[]");
        }

        return $this->returnResourceType($this->manager->createData($resource), $resultType);
    }

    private function returnResourceType(Scope $resource, $resultType)
    {
        switch ($resultType) {
            case self::JSON:
                $result = $resource->toJson();
                break;
            case self::ARRAY:
                $result = $resource->toArray();
                break;
            default:
                throw new \Exception("Tipo no soportado");
        }

        return $result;
    }
}
