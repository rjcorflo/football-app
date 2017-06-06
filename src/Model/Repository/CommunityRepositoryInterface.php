<?php

namespace RJ\PronosticApp\Model\Repository;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\Exception\NotFoundException;

/**
 * Repository for {@link CommunityInterface} entities.
 *
 * @method CommunityInterface create()
 * @method int store(CommunityInterface $community)
 * @method int[] storeMultiple(array $communities)
 * @method void trash(CommunityInterface $community)
 * @method void trashMultiple(array $communities)
 * @method CommunityInterface getById(int $idCommunity)
 * @method CommunityInterface[] getMultipleById(array $idsCommunities)
 * @method CommunityInterface[] findAll()
 */
interface CommunityRepositoryInterface extends StandardRepositoryInterface
{
    /** @var string */
    const ENTITY = 'community';

    /**
     * Check if a community name exists.
     *
     * @param string $name
     * @return bool
     */
    public function checkIfNameExists(string $name) : bool;

    /**
     * Find community by exact name.
     *
     * @param string $name
     * @return CommunityInterface
     * @throws NotFoundException If there is no communities with that name
     */
    public function findByName(string $name): CommunityInterface;

    /**
     * Get all public communities.
     *
     * If a player is passed, retrieve all public communities to which player is not a member.
     *
     * @param PlayerInterface $player
     * @return CommunityInterface[]
     */
    public function getAllPublicCommunities(PlayerInterface $player = null) : array;

    /**
     * Retrieve a random community.
     *
     * If a player is passed, retrieve random community to which player is not member.
     *
     * @param PlayerInterface|null $player
     * @return CommunityInterface
     */
    public function getRandomCommunity(PlayerInterface $player = null): CommunityInterface;
}
