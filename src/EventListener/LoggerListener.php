<?php

namespace App\EventListener;

use App\Event\Google\AnalyticsSendEvent;
use Psr\Log\LoggerInterface;

/**
 * Class LoggerListener
 * @package App\EventListener
 */
class LoggerListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LoggerListener constructor.
     * @param LoggerInterface $analyticsLogger
     */
    public function __construct(LoggerInterface $analyticsLogger)
    {
        $this->logger = $analyticsLogger;
    }

    /**
     * @param AnalyticsSendEvent $event
     */
    public function onAnalyticsSend(AnalyticsSendEvent $event)
    {
        $data = [
            $event->getAnalytics()->toArray(),
            $event->getUrl()
        ];

        $title = $event->getAnalytics()->getEvent()->getCategory();

        $this->logger->info($title, $data);
    }
}
