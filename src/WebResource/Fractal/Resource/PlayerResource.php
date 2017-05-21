<?php
namespace RJ\PronosticApp\WebResource\Fractal\Resource;

use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Entity\TokenInterface;
use RJ\PronosticApp\WebResource\Fractal\FractalGenerator;
use RJ\PronosticApp\WebResource\Fractal\Transformer\PlayerTransformer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\TokenTransformer;

trait PlayerResource
{
    /**
     * @inheritdoc
     */
    public function createPlayerResource(
        $player,
        $resultType = FractalGenerator::JSON
    ) {
        if ($player instanceof PlayerInterface) {
            $resource = new Item(
                $player,
                $this->container->get(PlayerTransformer::class)
            );
        } elseif (is_array($player)) {
            $resource = new Collection(
                $player,
                $this->container->get(PlayerTransformer::class)
            );
        } else {
            throw new \Exception("El recurso pasado no es un instancia que implemente " .
                "PlayerInterface o sea un array PlayerInterface[]");
        }

        return $this->returnResourceType(
            $this->manager->createData($resource),
            $resultType
        );
    }

    /**
     * @inheritdoc
     */
    public function createTokenResource(
        $token,
        $resultType = FractalGenerator::JSON
    ) {
        if ($token instanceof TokenInterface) {
            $resource = new Item(
                $token,
                $this->container->get(TokenTransformer::class)
            );
        } elseif (is_array($token)) {
            $resource = new Collection(
                $token,
                $this->container->get(TokenTransformer::class)
            );
        } else {
            throw new \Exception("El recurso pasado no es un instancia que implemente " .
                "TokenInterface o sea un array TokenInterface[]");
        }

        return $this->returnResourceType(
            $this->manager->createData($resource),
            $resultType
        );
    }
}
