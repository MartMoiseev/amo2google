<?php

namespace App\Entity\Amo;

use DateTimeInterface;

/**
 * Class AmoData
 * @package App\Entity\Amo
 */
class AmoData
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var AmoStatus
     */
    private $status;

    /**
     * @var AmoStatus
     */
    private $oldStatus;

    /**
     * @var DateTimeInterface
     */
    private $createTime;

    /**
     * @var DateTimeInterface
     */
    private $updateTime;

    /**
     * @var DateTimeInterface
     */
    private $sendTime;

    /**
     * @var string
     */
    private $price;

    /**
     * @var AmoUtm
     */
    private $utm;

    /**
     * AmoData constructor.
     * @param int $id
     * @param AmoStatus $status
     * @param AmoStatus $oldStatus
     * @param DateTimeInterface $createTime
     * @param DateTimeInterface $updateTime
     * @param DateTimeInterface $sendTime
     * @param string $price
     * @param AmoUtm $utm
     */
    public function __construct(
        int $id, AmoStatus $status, AmoStatus $oldStatus,
        DateTimeInterface $createTime, DateTimeInterface $updateTime, DateTimeInterface $sendTime,
        string $price, AmoUtm $utm)
    {
        $this->id = $id;
        $this->status = $status;
        $this->oldStatus = $oldStatus;
        $this->createTime = $createTime;
        $this->updateTime = $updateTime;
        $this->sendTime = $sendTime;
        $this->price = $price;
        $this->utm = $utm;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return AmoStatus
     */
    public function getStatus(): AmoStatus
    {
        return $this->status;
    }

    /**
     * @return AmoStatus
     */
    public function getOldStatus(): AmoStatus
    {
        return $this->oldStatus;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreateTime(): DateTimeInterface
    {
        return $this->createTime;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdateTime(): DateTimeInterface
    {
        return $this->updateTime;
    }

    /**
     * @return DateTimeInterface
     */
    public function getSendTime(): DateTimeInterface
    {
        return $this->sendTime;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return AmoUtm
     */
    public function getUtm(): AmoUtm
    {
        return $this->utm;
    }
}
