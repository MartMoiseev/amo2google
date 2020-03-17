<?php

namespace App\Event\Amo;

use App\Entity\Amo\AmoRequest;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class HookRegisteredEvent
 * @package App\Event\Amo
 */
class HookRegisteredEvent extends Event
{
    /**
     * Префикс события сортировки хука
     */
    public const PREFIX = 'hook.';

    /**
     * @var AmoRequest
     */
    protected $amoRequest;

    /**
     * HookRegisteredEvent constructor.
     * @param AmoRequest $amoRequest
     */
    public function __construct(AmoRequest $amoRequest)
    {
        $this->amoRequest = $amoRequest;
    }

    /**
     * @return AmoRequest
     */
    public function getAmoRequest()
    {
        return $this->amoRequest;
    }

    /**
     * Формируем событие в формате 'hook.entity.event', например 'hook.leads.status'
     * @return string
     */
    public function getEventName(): string
    {
        return self::PREFIX . $this->amoRequest->getEntity() . '.' . $this->amoRequest->getEvent();
    }
}
