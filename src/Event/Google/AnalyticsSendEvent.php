<?php

namespace App\Event\Google;

use App\Entity\Google\BasicAnalytics;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class AnalyticsSendEvent
 * @package App\Event\Google
 */
class AnalyticsSendEvent extends Event
{
    /**
     * Префикс события сортировки хука
     */
    public const NAME = 'analytics.send';

    /**
     * @var BasicAnalytics
     */
    protected $analytics;

    /**
     * @var string
     */
    protected $url;

    /**
     * HookRegisteredEvent constructor.
     * @param BasicAnalytics $analytics
     * @param string $url
     */
    public function __construct(BasicAnalytics $analytics, string $url)
    {
        $this->analytics = $analytics;
        $this->url = $url;
    }

    /**
     * @return BasicAnalytics
     */
    public function getAnalytics()
    {
        return $this->analytics;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
