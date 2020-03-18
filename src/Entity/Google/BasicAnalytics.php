<?php

namespace App\Entity\Google;

/**
 * Class BasicAnalytics
 * @package App\Entity\Google
 */
class BasicAnalytics
{
    /**
     * В значения ключа “cid” присваивать значения из AmoCRM с поля “clientId” , в том случае,
     * если же этого значения нету - события не отправлять.
     *
     * @var string
     */
    private $clientId;

    /**
     * @var EventAnalytics
     */
    private $event;

    /**
     * @var CampaignAnalytics
     */
    private $campaign;

    /**
     * Передавать значения 1, если разница даты и времени
     * создания заявки и отправки на сервер Google EventAnalytics меньше 25 мин,
     * если разница даты создания заявки и отправки больше одного часа присваивать значения 0.
     *
     * @var int
     */
    private $nonInteractionHit;

    /**
     * BasicAnalytics constructor.
     * @param string $clientId
     * @param int $nonInteractionHit
     */
    public function __construct(string $clientId, int $nonInteractionHit)
    {
        $this->clientId = $clientId;
        $this->nonInteractionHit = $nonInteractionHit;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return EventAnalytics
     */
    public function getEvent(): ?EventAnalytics
    {
        return $this->event;
    }

    /**
     * @return CampaignAnalytics
     */
    public function getCampaign(): ?CampaignAnalytics
    {
        return $this->campaign;
    }

    /**
     * @return int
     */
    public function getNonInteractionHit(): int
    {
        return $this->nonInteractionHit;
    }

    /**
     * @param EventAnalytics $event
     */
    public function setEvent(EventAnalytics $event): void
    {
        $this->event = $event;
    }

    /**
     * @param CampaignAnalytics $campaign
     */
    public function setCampaign(CampaignAnalytics $campaign): void
    {
        $this->campaign = $campaign;
    }
}
