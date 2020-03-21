<?php

namespace App\Services\HookHandler;

use App\Services\HookHandler\HookHandlerInterface;
use App\Services\Google\AnalyticsFacade;
use App\Services\Google\AnalyticsFactory;

/**
 * Class HookHandlerFactory
 * @package App\Services\HookHandler
 */
class HookHandlerFactory
{
    /**
     * @var AnalyticsFacade
     */
    private $facade;

    /**
     * @var AnalyticsFactory
     */
    private $factory;

    /**
     * HookHandlerFactory constructor.
     * @param AnalyticsFacade $facade
     * @param AnalyticsFactory $factory
     */
    public function __construct(AnalyticsFacade $facade, AnalyticsFactory $factory)
    {
        $this->facade = $facade;
        $this->factory = $factory;
    }

    /**
     * @return HookHandlerInterface
     */
    public function create(): HookHandlerInterface
    {
        return new NewLeadHandler($this->facade, $this->factory);
    }
}
