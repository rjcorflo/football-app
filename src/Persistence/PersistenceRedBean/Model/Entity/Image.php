<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\ImageInterface;

class Image extends SimpleModel implements ImageInterface
{
    /**
     * @inheritDoc
     */
    public function getId() : int
    {
        $this->bean->id;
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
}
