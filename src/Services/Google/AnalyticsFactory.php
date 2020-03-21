<?php

namespace App\Services\Google;

use App\Entity\Amo\AmoData;
use App\Entity\Amo\AmoUtm;
use App\Entity\Google\BasicAnalytics;
use App\Entity\Google\CampaignAnalytics;
use App\Entity\Google\EventAnalytics;

/**
 * Class AnalyticsFactory
 * @package App\Services\Google
 */
class AnalyticsFactory
{
    /**
     * @param AmoData $data
     * @param string $eventCategory
     * @param bool $isLongTime
     * @return BasicAnalytics
     */
    public function newAnalytics(AmoData $data, string $eventCategory, bool $isLongTime): BasicAnalytics
    {
        $utm = $data->getUtm();
        $basic = new BasicAnalytics($utm->getClientId(), $this->getNonInteractionHit($isLongTime));

        $basic->setEvent(
            new EventAnalytics(
                $eventCategory,
                $this->getEventAction($utm),
                $this->getEventLabel($data),
                $this->getPrice($data, $eventCategory)
            )
        );

        if ($isLongTime) {
            $basic->setCampaign($this->getCampaign($utm));
        }

        return $basic;
    }

    /**
     * @param AmoData $data
     * @param string $eventCategory
     * @return string|null
     */
    private function getPrice(AmoData $data, string $eventCategory): ?string
    {
        if ($eventCategory == EventAnalytics::CATEGORY_PAID_ONE_MONTH) {
            return $data->getPrice();
        }

        return null;
    }

    /**
     * @param AmoUtm $utm
     * @return string
     */
    private function getEventAction(AmoUtm $utm): string
    {
        return $utm->getSource() . ' / ' . $utm->getMedium();
    }

    /**
     * @param AmoData $data
     * @return string
     */
    private function getEventLabel(AmoData $data): string
    {
        return
            $data->getCreateTime()->format('Y-m-d H:i') . ' | ' .
            $data->getUpdateTime()->format('Y-m-d H:i') . ' | ' .
            $data->getSendTime()->format('Y-m-d H:i');
    }

    /**
     * @param bool $isLongTime
     * @return int
     */
    private function getNonInteractionHit(bool $isLongTime): int
    {
        return $isLongTime ? 0 : 1;
    }

    /**
     * @param AmoUtm $utm
     * @return CampaignAnalytics
     */
    private function getCampaign(AmoUtm $utm): CampaignAnalytics
    {
        return new CampaignAnalytics(
            $utm->getSource(),
            $utm->getMedium(),
            $utm->getCampaign(),
            $utm->getTerm(),
            $utm->getContent()
        );
    }
}
