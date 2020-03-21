<?php

namespace App\Services\Google;

use App\Entity\Google\BasicAnalytics;
use App\Entity\Google\CampaignAnalytics;
use App\Entity\Google\EventAnalytics;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use TheIconic\Tracking\GoogleAnalytics\Analytics;

/**
 * Class AnalyticsFacade
 * @package App\Services\Google
 */
class AnalyticsFacade
{
    /**
     * @var BasicAnalytics
     */
    private $analytics;

    /**
     * AnalyticsFacade constructor.
     * @param ParameterBagInterface $params
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->analytics = new Analytics();

        $this->analytics
            ->setProtocolVersion('1')
            ->setTrackingId($params->get('google.tracker_id'));
    }

    /**
     * @param BasicAnalytics $basicAnalytics
     * @throws Exception
     */
    public function send(BasicAnalytics $basicAnalytics)
    {
        $this->analytics
            ->setClientId($basicAnalytics->getClientId())
            ->setNonInteractionHit($basicAnalytics->getNonInteractionHit());

        if ($basicAnalytics->getEvent()) {
            $this->setEvent($basicAnalytics->getEvent());
        }

        if ($basicAnalytics->getCampaign()) {
            $this->setCampaign($basicAnalytics->getCampaign());
        }

        $response = $this->analytics->sendEvent();

        if ($response->getHttpStatusCode() !== 200) {
            throw new Exception('Google analytics send error!');
        }
    }

    /**
     * @param EventAnalytics $eventAnalytics
     */
    private function setEvent(EventAnalytics $eventAnalytics)
    {
        $this->analytics
            ->setEventCategory($eventAnalytics->getCategory())
            ->setEventAction($eventAnalytics->getAction())
            ->setEventLabel($eventAnalytics->getLabel());

        // Только для статуса paid_one_month
        if ($eventAnalytics->getValue()) {
            $this->analytics->setEventValue($eventAnalytics->getValue());
        }
    }

    /**
     * @param CampaignAnalytics $campaignAnalytics
     */
    private function setCampaign(CampaignAnalytics $campaignAnalytics)
    {
        $this->analytics
            ->setCampaignSource($campaignAnalytics->getSource())
            ->setCampaignMedium($campaignAnalytics->getMedium())
            ->setCampaignName($campaignAnalytics->getName())
            ->setCampaignKeyword($campaignAnalytics->getKeyword())
            ->setCampaignContent($campaignAnalytics->getContent());
    }
}
