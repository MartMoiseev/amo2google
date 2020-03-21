<?php

namespace App\Entity\Amo;

/**
 * Class AmoData
 * @package App\Entity\Amo
 */
class AmoStatus
{
    const STATUS_NEW_LEAD = 'NEW_LEAD';
    const STATUS_TEST_PERIOD = 'TEST_PERIOD';
    const STATUS_PAID_ONE_MONTH = 'PAID_ONE_MONTH';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * AmoStatus constructor.
     * @param int $id
     * @param string $title
     */
    public function __construct(int $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
