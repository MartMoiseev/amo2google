<?php

namespace App\Services\HookHandler;

use App\Entity\NewOrder;
use App\Services\Amo\FieldsConverter;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 * Class NewLeadTimeoutHandler
 * @package App\Services\HookHandler
 */
class NewLeadTimeoutHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var NewLeadHandler
     */
    private $handler;

    /**
     * @var FieldsConverter
     */
    private $converter;

    /**
     * NewLeadTimeoutHandler constructor.
     * @param EntityManagerInterface $manager
     * @param NewLeadHandler $handler
     * @param FieldsConverter $converter
     */
    public function __construct(
        EntityManagerInterface $manager,
        NewLeadHandler $handler,
        FieldsConverter $converter
    )
    {
        $this->manager = $manager;
        $this->handler = $handler;
        $this->converter = $converter;
    }

    /**
     * Save new lead fo timeout send
     *
     * @param array $fields
     * @throws Exception
     */
    public function handle(array $fields): void
    {
        $order = new NewOrder();

        $order->setOrderId($fields['id']);
        $order->setData($fields);
        $order->setIsSend(true);
        $order->setSendTime(new \DateTime('', new \DateTimeZone('Europe/Kiev')));

        // Send to google!
        $amo = $this->converter->convert($order->getData());
        $this->handler->sendNew($amo);

        $this->manager->persist($order);
        $this->manager->flush();
    }
}
