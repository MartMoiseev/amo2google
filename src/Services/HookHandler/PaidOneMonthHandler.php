<?php

namespace App\Services\HookHandler;

use App\Entity\Amo\AmoData;
use App\Entity\Amo\AmoStatus;
use App\Entity\Google\EventAnalytics;
use App\Services\Google\AnalyticsFacade;
use App\Services\Google\AnalyticsFactory;
use DateTimeInterface;
use Exception;

/**
 * Class PaidOneMonthHandler
 * @package App\Services\HookHandler
 */
class PaidOneMonthHandler extends AbstractHookHandler
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
     * NewLeadHandler constructor.
     * @param AnalyticsFacade $facade
     * @param AnalyticsFactory $factory
     */
    public function __construct(AnalyticsFacade $facade, AnalyticsFactory $factory)
    {
        $this->facade = $facade;
        $this->factory = $factory;
    }

    /**
     * @param AmoData $data
     * @throws Exception
     */
    public function handle(AmoData $data): void
    {
        // Если статус сменился на оплачен 1 месяц
        if ($data->getStatus()->getTitle() == AmoStatus::STATUS_PAID_ONE_MONTH) {

            // Если перескочили через тестовый период
            if ($data->getOldStatus()->getTitle() != AmoStatus::STATUS_TEST_PERIOD) {

                // Отправляем пропущенный тестовый период
                $isLongTime = $this->isLongTime($data->getCreateTime(), $data->getSendTime());
                $analytics = $this->factory->newAnalytics($data, EventAnalytics::CATEGORY_TEST_PERIOD, $isLongTime);
                $this->facade->send($analytics);
            }

            // Отправляем оплачен 1 месяц
            $isLongTime = $this->isLongTime($data->getCreateTime(), $data->getSendTime());
            $analytics = $this->factory->newAnalytics($data, EventAnalytics::CATEGORY_PAID_ONE_MONTH, $isLongTime);
            $this->facade->send($analytics);
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
}
