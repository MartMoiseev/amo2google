<?php

namespace App\Services\Amo;

use App\Entity\Amo\AmoRequest;
use App\Event\Amo\HookRegisteredEvent;
use DateTimeInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class HookRegisterService
 * @package App\Services\Amo
 */
class HookRegisterService
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * HookRegisterService constructor.
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param string $request
     * @param DateTimeInterface $date
     */
    public function register(string $request, DateTimeInterface $date): void
    {
        $amoData = $this->parseRequest($request, $date);

        $event = new HookRegisteredEvent($amoData);
        $this->dispatcher->dispatch($event, $event->getEventName());
    }

    /**
     * @param string $request
     * @param DateTimeInterface $date
     * @return AmoRequest
     */
    protected function parseRequest(string $request, DateTimeInterface $date): AmoRequest
    {
        $body = json_decode($request, true);

        $entityName = array_key_first($body);
        $eventName = array_key_first($body[$entityName]);
        $fields = $body[$entityName][$eventName];

        return new AmoRequest($entityName, $eventName, $fields, $date);
    }
}
