<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity;

use RedBeanPHP\SimpleModel;
use RJ\PronosticApp\Model\Entity\CommunityInterface;
use RJ\PronosticApp\Model\Entity\GeneralclassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayclassificationInterface;
use RJ\PronosticApp\Model\Entity\MatchdayInterface;
use RJ\PronosticApp\Model\Entity\PlayerInterface;

/**
 * Class Generalclassification
 *
 * @package RJ\PronosticApp\Persistence\PersistenceRedBean\Model\Entity
 */
class Generalclassification extends SimpleModel implements GeneralclassificationInterface
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

    /**
     * @inheritDoc
     */
    public function getPosition(): int
    {
        return $this->bean->position;
    }

    /**
     * @inheritDoc
     */
    public function setPosition(int $position): void
    {
        $this->bean->position = $position;
    }

    /**
     * @inheritDoc
     */
    public function getTimesFirst(): int
    {
        return $this->bean->times_first;
    }

    /**
     * @inheritDoc
     */
    public function setTimesFirst(int $times): void
    {
        $this->bean->times_first = $times;
    }

    /**
     * @inheritDoc
     */
    public function getTimesSecond(): int
    {
        return $this->bean->times_second;
    }

    /**
     * @inheritDoc
     */
    public function setTimesSecond(int $times): void
    {
        $this->bean->times_second = $times;
    }

    /**
     * @inheritDoc
     */
    public function getTimesThird(): int
    {
        return $this->bean->times_third;
    }

    /**
     * @inheritDoc
     */
    public function setTimesThird(int $times): void
    {
        $this->bean->times_third = $times;
    }


    /**
     * @inheritDoc
     */
    public function setLastModifiedDate(\DateTime $lastModified): void
    {
        $this->bean->last_modified_date = $lastModified;
    }

    /**
     * @inheritDoc
     */
    public function getLastModifiedDate(): \DateTime
    {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $this->bean->last_modified_date);
    }
}
