<?php

namespace RJ\PronosticApp\WebResource\Fractal;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Scope;
use Psr\Container\ContainerInterface;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Util\General\ForecastResult;
use RJ\PronosticApp\Util\General\MessageResult;
use RJ\PronosticApp\WebResource\Fractal\Resource\CommunityListResource;
use RJ\PronosticApp\WebResource\Fractal\Resource\MatchListResource;
use RJ\PronosticApp\WebResource\Fractal\Resource\PlayerResource;
use RJ\PronosticApp\WebResource\Fractal\Serializer\NoDataArraySerializer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\CommunityDataTransformer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\CommunityListTransformer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\CommunityTransformer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\ImageTransformer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\MatchListTransformer;
use RJ\PronosticApp\WebResource\Fractal\Transformer\MessageResultTransformer;
use RJ\PronosticApp\WebResource\WebResourceGeneratorInterface;

/**
 * Class FractalGenerator.
 *
 * Generate resources in JSON.
 *
 * @package RJ\PronosticApp\WebResource\Fractal
 */
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
     * @param ContainerInterface $container
     * @param Manager $manager
     */
    public function __construct(ContainerInterface $container, Manager $manager)
    {
        $this->container = $container;
        $this->manager = $manager;
        $this->manager->setSerializer(new NoDataArraySerializer());
    }

    /**
     * @inheritDoc
     */
    public function include(string $includes)
    {
        $this->manager->parseIncludes($includes);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function exclude(string $excludes)
    {
        $this->manager->parseExcludes($excludes);
        return $this;
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function createForecastMessageResource(ForecastResult $message, $resultType = self::JSON)
    {
        $resource = new Item($message, function (ForecastResult $message) {
            return [
                'fecha_actual' => $message->getDate()->format('Y-m-d H:i:s'),
                'id_jornada' => $message->getMatchdayId(),
                'confirmados' => $message->getCorrects(),
                'errores' => $message->getErrors()
            ];
        });

        return $this->returnResourceType(
            $this->manager->createData($resource),
            $resultType
        );
    }


    /**
     * @inheritDoc
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
    public function createCommunityListResource(
        $communities,
        $resultType = self::JSON
    ) {
        if (is_array($communities)) {
            $data = new CommunityListResource($communities);
            $resource = new Item($data, $this->container->get(CommunityListTransformer::class));
        } else {
            throw new \Exception("El recurso pasado no es un array CommunityInterface[]");
        }

        return $this->returnResourceType(
            $this->manager->createData($resource),
            $resultType
        );
    }

    /**
     * @inheritDoc
     */
    public function createCommunityDataResource($communities, $resultType = self::JSON)
    {
        if ($communities instanceof CommunityInterface) {
            $resource = new Item($communities, $this->container->get(CommunityDataTransformer::class));
        } elseif (is_array($communities)) {
            $resource = new Collection($communities, $this->container->get(CommunityDataTransformer::class));
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

    /**
     * @inheritDoc
     */
    public function createActiveMatchesResource($matches, $resultType = self::JSON)
    {
        if (is_array($matches)) {
            $data = new MatchListResource($matches);
            $resource = new Item($data, $this->container->get(MatchListTransformer::class));
        } else {
            throw new \Exception("El recurso pasado no un array MatchInterface[]");
        }

        return $this->returnResourceType(
            $this->manager->createData($resource),
            $resultType
        );
    }

    /**
     * @param Scope $resource
     * @param $resultType
     * @return array|string
     * @throws \Exception
     */
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
