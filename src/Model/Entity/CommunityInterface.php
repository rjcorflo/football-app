<?php

namespace RJ\FootballApp\Model\Entity;

interface CommunityInterface
{
    public function getId() : int;

    public function setCommunityName(string $communityName);

    public function getCommunityName() : string;

    public function setPassword(string $password);

    public function getPassword() : string;

    public function setPrivate(bool $isPrivate);

    public function isPrivate() : bool;

    public function setCreationDate(\DateTime $date);

    public function getCreationDate() : \DateTime;
}
