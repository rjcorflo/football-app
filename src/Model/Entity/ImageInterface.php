<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Image interface.
 */
interface ImageInterface
{
    /**
     * @return int
     */
    public function getId() : int;

    /**
     * @param string $url
     */
    public function setUrl(string $url) : void;

    /**
     * @return string
     */
    public function getUrl() : string;
}
