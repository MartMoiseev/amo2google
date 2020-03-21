<?php

namespace App\EventListener;

use App\Event\Amo\HookRegisteredEvent;
use App\Exception\NoCustomFieldsException;
use App\Services\HookHandler\HookHandlerFactory;
use App\Services\Amo\FieldsConverter;
use Exception;

/**
 * Class LeadsStatusListener
 * @package App\EventListener
 */
class LeadsStatusListener
{
    /**
     * @var FieldsConverter
     */
    private $converter;

    /**
     * @var HookHandlerFactory
     */
    private $factory;

    /**
     * LeadsStatusListener constructor.
     * @param FieldsConverter $converter
     * @param HookHandlerFactory $factory
     */
    public function __construct(FieldsConverter $converter, HookHandlerFactory $factory)
    {
        $this->converter = $converter;
        $this->factory = $factory;
    }

    /**
     * @param HookRegisteredEvent $event
     */
    public function onHookLeadsStatus(HookRegisteredEvent $event)
    {
        $fields = $event->getAmoRequest()->getFields()[0];

        try {
            $data = $this->converter->convert($fields);
            $hookHandler = $this->factory->create();
            $hookHandler->handle($data);
        } catch (NoCustomFieldsException $exception) {
            dd($exception);
        } catch (Exception $exception) {
            dd ($exception);
        }
    }
}
