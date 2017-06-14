<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\MatchdayClassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Class MatchdayClassification
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity
 */
class MatchdayClassification extends SimpleModel implements MatchdayClassificationInterface
{
    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->bean->id;
    }

    /**
     * @inheritDoc
     */
    public function getPlayer(): PlayerInterface
    {
        return $this->bean->player->box();
    }

    /**
     * @inheritDoc
     */
    public function setPlayer(PlayerInterface $player): void
    {
        $this->bean->player = $player->unbox();
    }

    /**
     * @inheritDoc
     */
    public function getCommunity(): CommunityInterface
    {
        return $this->bean->community->box();
    }

    /**
     * @inheritDoc
     */
    public function setCommunity(CommunityInterface $community): void
    {
        $this->bean->community = $community->unbox();
    }

    /**
     * @inheritDoc
     */
    public function getMatchday(): MatchdayInterface
    {
        return $this->bean->matchday->box();
    }

    /**
     * @inheritDoc
     */
    public function setMatchday(MatchdayInterface $matchday): void
    {
        $this->bean->matchday = $matchday->unbox();
    }

    /**
     * @inheritDoc
     */
    public function getTotalPoints(): int
    {
        return $this->bean->total_points;
    }

    /**
     * @inheritDoc
     */
    public function setTotalPoints(int $points): void
    {
        $this->bean->total_points = $points;
    }

    /**
     * @inheritDoc
     */
    public function getHitsTenPoints(): int
    {
        return $this->bean->hits_ten_points;
    }

    /**
     * @inheritDoc
     */
    public function setHitsTenPoints(int $hits): void
    {
        $this->bean->hits_ten_points = $hits;
    }

    /**
     * @inheritDoc
     */
    public function getHitsFivePoints(): int
    {
        return $this->bean->hits_five_points;
    }

    /**
     * @inheritDoc
     */
    public function setHitsFivePoints(int $hits): void
    {
        $this->bean->hits_five_points = $hits;
    }

    /**
     * @inheritDoc
     */
    public function getHitsThreePoints(): int
    {
        return $this->bean->hits_three_points;
    }

    /**
     * @inheritDoc
     */
    public function setHitsThreePoints(int $hits): void
    {
        $this->bean->hits_three_points = $hits;
    }

    /**
     * @inheritDoc
     */
    public function getHitsTwoPoints(): int
    {
        return $this->bean->hits_two_points;
    }

    /**
     * @inheritDoc
     */
    public function setHitsTwoPoints(int $hits): void
    {
        $this->bean->hits_two_points = $hits;
    }

    /**
     * @inheritDoc
     */
    public function getHitsOnePoints(): int
    {
        return $this->bean->hits_one_points;
    }

    /**
     * @inheritDoc
     */
    public function setHitsOnePoints(int $hits): void
    {
        $this->bean->hits_one_points = $hits;
    }

    /**
     * @inheritDoc
     */
    public function getHitsNegativePoints(): int
    {
        return $this->bean->hits_negative_points;
    }

    /**
     * @inheritDoc
     */
    public function setHitsNegativePoints(int $hits): void
    {
        $this->bean->hits_negative_points = $hits;
    }
}
