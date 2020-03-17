<?php

namespace App\Entity\Amo;

use DateTimeInterface;

/**
 * Class AmoRequest
 * @package App\Entity
 */
class AmoRequest
{
    /**
     * @var string
     */
    private $entity;

    /**
     * @var string
     */
    private $event;

    /**
     * @var array
     */
    private $fields = [];

    /**
     * @var DateTimeInterface
     */
    private $registeredTime;

    /**
     * AmoRequest constructor.
     * @param string $entity
     * @param string $event
     * @param array $fields
     * @param DateTimeInterface $registeredTime
     */
    public function __construct(string $entity, string $event, array $fields, DateTimeInterface $registeredTime)
    {
        $this->entity = $entity;
        $this->event = $event;
        $this->fields = $fields;
        $this->registeredTime = $registeredTime;
    }

    /**
     * @return string|null
     */
    public function getEntity(): ?string
    {
        return $this->entity;
    }

    /**
     * @return string|null
     */
    public function getEvent(): ?string
    {
        return $this->event;
    }

    /**
     * @return array|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }

    /**
     * @return DateTimeInterface
     */
    public function getRegisteredTime(): DateTimeInterface
    {
        return $this->registeredTime;
    }
}
