<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\ImageInterface;

/**
 * Class Image.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity
 */
class Image extends SimpleModel implements ImageInterface
{
    /**
     * @inheritDoc
     */
    public function getId() : int
    {
        return $this->bean->id;
    }

    /**
     * @inheritDoc
     */
    public function setUrl(string $url) : void
    {
        $this->bean->url = $url;
    }

    /**
     * @inheritDoc
     */
    public function getUrl() : string
    {
        return $this->bean->url;
    }

    /**
     * @inheritDoc
     */
    public function setDescription(string $description): void
    {
        $this->bean->description = $description;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return $this->bean->description;
    }
}
