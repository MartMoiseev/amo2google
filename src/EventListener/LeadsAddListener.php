<?php

namespace App\EventListener;

use App\Event\Amo\HookRegisteredEvent;
use App\Exception\NoCustomFieldsException;
use App\Services\HookHandler\HookHandlerFactory;
use App\Services\Amo\FieldsConverter;
use App\Services\HookHandler\NewLeadTimeoutHandler;
use Exception;

/**
 * Class LeadsAddListener
 * @package App\EventListener
 */
class LeadsAddListener
{
    /**
     * @var FieldsConverter
     */
    private $converter;

    /**
     * @var NewLeadTimeoutHandler
     */
    private $handler;

    /**
     * LeadsAddListener constructor.
     * @param FieldsConverter $converter
     * @param NewLeadTimeoutHandler $handler
     */
    public function __construct(FieldsConverter $converter, NewLeadTimeoutHandler $handler)
    {
        $this->converter = $converter;
        $this->handler = $handler;
    }

    /**
     * @param HookRegisteredEvent $event
     */
    public function onHookLeadsAdd(HookRegisteredEvent $event)
    {
        $fields = $event->getAmoRequest()->getFields()[0];

        try {
            $this->handler->handle($fields);
        } catch (NoCustomFieldsException $exception) {
            dd($exception);
        } catch (Exception $exception) {
            dd ($exception);
        }
    }
}
