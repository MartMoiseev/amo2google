<?php

namespace App\Services\HookHandler;

use App\Entity\Amo\AmoData;
use App\Entity\Amo\AmoStatus;
use App\Entity\Google\EventAnalytics;
use App\Repository\NewOrderRepository;
use App\Services\Google\AnalyticsFacade;
use App\Services\Google\AnalyticsFactory;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

/**
 * Class NewLeadHandler
 * @package App\Services\HookHandler
 */
class NewLeadHandler extends AbstractHookHandler
{
    const LONG_TIME_PERIOD = 25;

    /**
     * @var AnalyticsFacade
     */
    private $facade;

    /**
     * @var AnalyticsFactory
     */
    private $factory;

    /**
     * @var NewOrderRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * NewLeadHandler constructor.
     * @param AnalyticsFacade $facade
     * @param AnalyticsFactory $factory
     * @param NewOrderRepository $repository
     * @param EntityManagerInterface $manager
     */
    public function __construct(
        AnalyticsFacade $facade, AnalyticsFactory $factory,
        NewOrderRepository $repository, EntityManagerInterface $manager)
    {
        $this->facade = $facade;
        $this->factory = $factory;
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @param AmoData $data
     * @throws Exception
     */
    public function handle(AmoData $data): void
    {
        // Если статус сменился с новый на любой другой и заявка не была отправлена ранее
        if ($data->getOldStatus()->getTitle() == AmoStatus::STATUS_NEW_LEAD and !$this->isSend($data)) {
            // отправляем заявку
            $isLongTime = $this->isLongTime($data->getCreateTime(), $data->getSendTime());
            $analytics = $this->factory->newAnalytics($data, EventAnalytics::CATEGORY_NEW_LEAD, $isLongTime);
            $this->facade->send($analytics);

            // обновляем статус заявки, если она была ранее создана
            $this->closeNewOrder($data);
        }

        if ($this->next) {
            $this->next->handle($data);
        }
    }

    /**
     * @param DateTimeInterface $createTime
     * @param DateTimeInterface $sendTime
     * @return bool
     */
    private function isLongTime(DateTimeInterface $createTime, DateTimeInterface $sendTime): bool
    {
        $delta = ($sendTime->format('U') - $createTime->format('U')) / 60;

        return $delta > self::LONG_TIME_PERIOD ? true : false;
    }

    /**
     * @param AmoData $data
     * @return bool
     */
    private function isSend(AmoData $data): bool
    {
        return (bool)$this->repository->count([
            'orderId' => $data->getId(),
            'isSend' => true
        ]);
    }

    /**
     * @param AmoData $data
     */
    private function closeNewOrder(AmoData $data): void
    {
        $order = $this->repository->findOneBy(['orderId' => $data->getId()]);

        // Если заявка существовала - помечаем как отправленную
        if ($order) {
            $order->setIsSend(true);
            $this->manager->flush();
        }
    }
}
