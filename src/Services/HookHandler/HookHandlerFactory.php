<?php

namespace App\Services\HookHandler;

use App\Repository\NewOrderRepository;
use App\Services\Google\AnalyticsFacade;
use App\Services\Google\AnalyticsFactory;
use Doctrine\ORM\EntityManagerInterface;

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
     * @var NewOrderRepository
     */
    private $newOrderRepository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * HookHandlerFactory constructor.
     * @param AnalyticsFacade $facade
     * @param AnalyticsFactory $factory
     * @param NewOrderRepository $newOrderRepository
     * @param EntityManagerInterface $manager
     */
    public function __construct(
        AnalyticsFacade $facade, AnalyticsFactory $factory,
        NewOrderRepository $newOrderRepository, EntityManagerInterface $manager)
    {
        $this->facade = $facade;
        $this->factory = $factory;
        $this->newOrderRepository = $newOrderRepository;
        $this->manager = $manager;
    }

    /**
     * @return HookHandlerInterface
     */
    public function create(): HookHandlerInterface
    {
        $newLead = new NewLeadHandler($this->facade, $this->factory, $this->newOrderRepository, $this->manager);
        $testPeriod = new TestPeriodHandler($this->facade, $this->factory);
        $paidOneMonth = new PaidOneMonthHandler($this->facade, $this->factory);

        $testPeriod->setNext($paidOneMonth);
        $newLead->setNext($testPeriod);

        return $newLead;
    }
}
