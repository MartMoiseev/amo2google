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
            AmoStatus::STATUS_NEW_LEAD => $this->toArray($parameterBag->get('amo.status.new_lead')),
            AmoStatus::STATUS_TEST_PERIOD => $this->toArray($parameterBag->get('amo.status.test_period')),
            AmoStatus::STATUS_PAID_ONE_MONTH => $this->toArray($parameterBag->get('amo.status.paid_one_month')),
        ];
    }

    /**
     * @param int $statusId
     * @return AmoStatus
     */
    public function create(int $statusId): AmoStatus
    {
        foreach ($this->statuses as $status => $ids) {
            $key = in_array($statusId, $ids);
            if ($key) {
                return new AmoStatus($statusId, $status);
            }
        }

        return new AmoStatus($statusId, '');
    }

    private function toArray(string $ids): array
    {
        // очищаем от лишних пробелов
        str_replace(' ', '', $ids);
        // формируем массив
        return explode(',', $ids);
    }
}
