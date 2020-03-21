<?php

namespace App\Services\HookHandler;

use App\Entity\Amo\AmoData;
use App\Entity\Amo\AmoStatus;
use App\Services\Google\AnalyticsFacade;
use App\Services\Google\AnalyticsFactory;
use DateTimeInterface;
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
        // Если статус сменился с новый на любой другой
        if ($data->getOldStatus()->getTitle() == AmoStatus::STATUS_NEW_LEAD) {
            $isLongTime = $this->isLongTime($data->getCreateTime(), $data->getSendTime());
            $analytics = $this->factory->newLead($data, $isLongTime);
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
