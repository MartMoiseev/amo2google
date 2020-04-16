<?php

namespace App\EventListener;

use App\Entity\Amo\AmoData;
use App\Event\Amo\HookRegisteredEvent;
use App\Exception\NoCustomFieldsException;
use App\Services\HookHandler\HookHandlerFactory;
use App\Services\Amo\FieldsConverter;
use DateTime;
use DateTimeInterface;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

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
     * @var DateTimeInterface
     */
    private $oldLeads;

    /**
     * LeadsStatusListener constructor.
     * @param FieldsConverter $converter
     * @param HookHandlerFactory $factory
     * @param ParameterBagInterface $parameterBag
     * @throws Exception
     */
    public function __construct(FieldsConverter $converter, HookHandlerFactory $factory, ParameterBagInterface $parameterBag)
    {
        $this->converter = $converter;
        $this->factory = $factory;

        $this->oldLeads = new DateTime($parameterBag->get('amo.old.leads'));
    }

    /**
     * @param HookRegisteredEvent $event
     */
    public function onHookLeadsStatus(HookRegisteredEvent $event)
    {
        $fields = $event->getAmoRequest()->getFields()[0];

        try {
            $data = $this->converter->convert($fields);
            if (!$this->isOld($data)) {
                $hookHandler = $this->factory->create();
                $hookHandler->handle($data);
            }
        } catch (NoCustomFieldsException $exception) {
            dd($exception);
        } catch (Exception $exception) {
            dd($exception);
        }
    }

    /**
     * @param AmoData $data
     * @return bool
     * @throws Exception
     */
    private function isOld(AmoData $data): bool
    {
        return $data->getCreateTime() < $this->oldLeads;
    }
}
