<?php

namespace RJ\PronosticApp\Model\Entity;

/**
 * Interface ImageInterface
 * @package RJ\PronosticApp\Model\Entity
 */
interface ImageInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param string $url
     */
    public function setUrl(string $url): void;

    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param string $description
     */
    public function setDescription(string $description): void;

    /**
     * @return string
     */
    public function getDescription(): string;
}
