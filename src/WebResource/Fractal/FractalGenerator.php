<?php

namespace RJ\PronosticApp\WebResource\Fractal;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Scope;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\WebResource\Fractal\Resource\PlayerResource;
use RJ\PronosticApp\WebResource\Fractal\Serializer\NoDataArraySerializer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\CommunityTransformer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\ImageTransformer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\MessageResultTransformer;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

class FractalGenerator implements WebResourceGeneratorInterface
{
    use PlayerResource;

    /**
     * @var \Psr\Container\ContainerInterface
     */
    private $container;

    /**
     * @var \League\Fractal\Manager
     */
    private $manager;

    /**
     * FractalGenerator constructor.
     * @param \League\Fractal\Manager $manager
     */
    public function __construct(ContainerInterface $container, Manager $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->manager->setSerializer(new NoDataArraySerializer());
    }

    /**
     * @inheritdoc
     */
    public function include(string $includes)
    {
        $this->manager->parseIncludes($includes);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function exclude(string $excludes)
    {
        $this->manager->parseExcludes($excludes);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function createMessageResource(
        MessageResult $message,
        $resultType = self::JSON
    ) {
        $resource = new Item($message, $this->container->get(MessageResultTransformer::class));
        return $this->returnResourceType(
            $this->manager->createData($resource),
            $resultType
        );
    }

    /**
     * @inheritdoc
     */
    public function createCommunityResource(
        $community,
        $resultType = self::JSON
    ) {
        if ($community instanceof CommunityInterface) {
            $resource = new Item($community, $this->container->get(CommunityTransformer::class));
        } elseif (is_array($community)) {
            $resource = new Collection($community, $this->container->get(CommunityTransformer::class));
        } else {
            throw new \Exception("El recurso pasado no es un instancia que implemente " .
                "CommunityInterface o sea un array CommunityInterface[]");
        }

        return $this->returnResourceType(
            $this->manager->createData($resource),
            $resultType
        );
    }

    /**
     * @inheritDoc
     */
    public function createImageResource($images, $resultType = self::JSON)
    {
        if ($images instanceof ImageInterface) {
            $resource = new Item($images, $this->container->get(ImageTransformer::class));
        } elseif (is_array($images)) {
            $resource = new Collection($images, $this->container->get(ImageTransformer::class));
        } else {
            throw new \Exception("El recurso pasado no es un instancia que implemente " .
                "ImageInterface o sea un array ImageInterface[]");
        }

        return $this->returnResourceType(
            $this->manager->createData($resource),
            $resultType
        );
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
