<?php

namespace App\Services\Amo;

use App\Entity\Amo\AmoStatus;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class HookRegisterService
 * @package App\Services\Amo
 */
class StatusService
{
    private $statuses = [];

    /**
     * StatusService constructor.
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->statuses = [
            AmoStatus::STATUS_NEW_LEAD => $parameterBag->get('amo.status.new_lead'),
            AmoStatus::STATUS_TEST_PERIOD => $parameterBag->get('amo.status.test_period'),
            AmoStatus::STATUS_PAID_ONE_MONTH => $parameterBag->get('amo.status.paid_one_month'),
        ];
    }

    /**
     * @param int $statusId
     * @return AmoStatus
     */
    public function create(int $statusId): AmoStatus
    {
        $key = array_search($statusId, $this->statuses);
        $status = $key ? $key : '';

        return new AmoStatus($statusId, $status);
    }
}
