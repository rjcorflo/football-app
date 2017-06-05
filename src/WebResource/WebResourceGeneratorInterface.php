<?php

namespace RJ\PronosticApp\WebResource;

use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\ImageInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;
use RJ\PronosticApp\Model\Entity\TokenInterface;
use RJ\PronosticApp\Util\General\MessageResult;

/**
 * Interface WebResourceGeneratorInterface.
 *
 * Creates web resource from entities.
 *
 * @package RJ\PronosticApp\WebResource
 */
interface WebResourceGeneratorInterface
{
    const JSON = 'json';

    const ARRAY = 'array';

    /**
     * @param string $includes
     * @return $this
     */
    public function include(string $includes);

    /**
     * @param string $excludes
     * @return $this
     */
    public function exclude(string $excludes);

    /**
     * @param MessageResult $messages
     * @param string $resultType
     * @return array|string
     */
    public function createMessageResource(MessageResult $messages, $resultType = self::JSON);

    /**
     * @param PlayerInterface|PlayerInterface[] $players
     * @param string $resultType
     * @return array|string
     */
    public function createPlayerResource($players, $resultType = self::JSON);

    /**
     * @param CommunityInterface|CommunityInterface[] $communities
     * @param string $resultType
     * @return array|string
     */
    public function createCommunityResource($communities, $resultType = self::JSON);

    /**
     * @param CommunityInterface|CommunityInterface[] $communities
     * @param string $resultType
     * @return array|string
     */
    public function createPublicCommunityResource($communities, $resultType = self::JSON);

    /**
     * @param TokenInterface|TokenInterface[] $tokens
     * @param string $resultType
     * @return array|string
     */
    public function createTokenResource($tokens, $resultType = self::JSON);

    /**
     * @param ImageInterface|ImageInterface[] $images
     * @param string $resultType
     * @return array|string
     */
    public function createImageResource($images, $resultType = self::JSON);
}
