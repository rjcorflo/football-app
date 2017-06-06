<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository;

use RedBeanPHP\R;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Repository\CommunityRepositoryInterface;
use RJ\PronosticApp\Model\Repository\Exception\NotFoundException;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity\Community;
use RJ\PronosticApp\Persistence\PersistenceRedBean\Util\RedBeanUtils;
use RJ\PronosticApp\Util\General\ErrorCodes;

/**
 * Class CommunityRepository.
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Repository
 */
class CommunityRepository extends AbstractRepository implements CommunityRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function checkIfNameExists(string $name) : bool
    {
        return R::count(static::ENTITY, 'name LIKE LOWER(?)', [$name]) > 0;
    }

    /**
     * @inheritDoc
     */
    public function findByName(string $name): CommunityInterface
    {
        /** @var Community $community */
        $community = R::findOne(static::ENTITY, 'name LIKE LOWER(?)', [$name]);

        if ($community === null) {
            $exception = new NotFoundException();
            $exception->addMessageWithCode(
                ErrorCodes::ENTITY_NOT_FOUND,
                'No existe una comunidad con ese nombre'
            );

            throw $exception;
        }

        return $community->box();
    }

    /**
     * @inheritDoc
     */
    public function getAllPublicCommunities(PlayerInterface $player = null): array
    {
        if ($player === null) {
            /** @var Community[] $commuties */
            $communities = R::find(static::ENTITY, 'private = 0 ORDER BY name ASC');
        } else {
            /** @var Community[] $commuties */
            $communities = R::find(
                static::ENTITY,
                'private = 0
                 AND id NOT IN (SELECT community_id
                                  FROM `participant` p
                                 WHERE p.player_id = ?)
                 ORDER BY name ASC',
                [$player->getId()]
            );
        }

        return RedBeanUtils::boxArray($communities);
    }

    /**
     * @inheritDoc
     */
    public function getRandomCommunity(PlayerInterface $player = null): CommunityInterface
    {
        if ($player === null) {
            $community = R::findOne(
                static::ENTITY,
                'creation_date = (SELECT MIN(creation_date) FROM community)'
            );
        } else {
            $community = R::findOne(
                static::ENTITY,
                'creation_date = (SELECT MIN(c.creation_date) 
                                    FROM community c
                                   WHERE c.private = 0
                                     AND NOT EXISTS (SELECT 1
                                                       FROM participant p
                                                      WHERE p.community_id = c.id
                                                        AND p.player_id = ?))
                 AND `community`.private = 0
                 AND NOT EXISTS (SELECT 1
                                   FROM participant p
                                  WHERE p.community_id = `community`.id
                                    AND p.player_id = ?)',
                [$player->getId(), $player->getId()]
            );
        }

        if ($community === null) {
            $exception = new NotFoundException();
            $exception->addMessageWithCode(
                ErrorCodes::CANNOT_RETRIEVE_RANDOM_COMMUNITY,
                'No se ha podido recuperar una comunidad aleatoria'
            );

            throw $exception;
        }

        return $community->box();
    }
}
