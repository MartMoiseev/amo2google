<?php

namespace App\Services\HookHandler;

use App\Entity\NewOrder;
use App\Repository\NewOrderRepository;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 * Class NewLeadTimeoutHandler
 * @package App\Services\HookHandler
 */
class NewLeadTimeoutHandler
{
    /**
     * @var NewOrderRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * NewLeadTimeoutHandler constructor.
     * @param NewOrderRepository $repository
     * @param EntityManagerInterface $manager
     */
    public function __construct(NewOrderRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @param array $fields
     * @throws Exception
     */
    public function handle(array $fields): void
    {
        $order = new NewOrder();

        $order->setOrderId($fields['id']);
        $order->setData($fields);
        $order->setIsSend(false);
        $order->setSendTime($this->getSendTime());

        $this->manager->persist($order);
        $this->manager->flush();
    }

    /**
     * @return DateTimeInterface
     * @throws Exception
     */
    private function getSendTime(): DateTimeInterface
    {
        $currentTime = new \DateTime();
        return $currentTime->modify('+20 min');
    }
}
