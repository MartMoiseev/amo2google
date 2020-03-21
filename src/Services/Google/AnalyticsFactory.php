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
     * @param bool $isLongTime
     * @return BasicAnalytics
     */
    public function newLead(AmoData $data, bool $isLongTime): BasicAnalytics
    {
        $utm = $data->getUtm();
        $basic = new BasicAnalytics($utm->getClientId(), $this->getNonInteractionHit($isLongTime));

        $basic->setEvent(
            new EventAnalytics(
                EventAnalytics::CATEGORY_NEW_LEAD,
                $this->getEventAction($utm),
                $this->getEventLabel($data),
                null
            )
        );

        if ($isLongTime) {
            $basic->setCampaign($this->getCampaign($utm));
        }

        return $basic;
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
