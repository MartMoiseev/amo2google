<?php

namespace App\Entity\Google;

/**
 * Class EventAnalytics
 * @package App\Entity\Google
 */
class EventAnalytics
{
    /**
     * “new_lead” - по статусу новая заявка
     * “test_period” - по статусу тестовый период
     * “paid_one_month” - по замер назначен
     *
     * @var string
     */
    private $category;

    /**
     * значения с поля “utm_source” и “utm_medium”, в формате: “utm_source / utm_medium”, пример: “google / cpc”
     *
     * @var string
     */
    private $action;

    /**
     * Дата и время создания заявки в Амо, Дата и время изменения заявки в Амо, Дата и время отправки на сервер Google EventAnalytics,
     * в таком формате “2019-10-31 29:03 | 2019-10-31 20:09 | 2019-10-31 20:15”
     *
     * @var string
     */
    private $label;

    /**
     * присваивать значения по статусу оплачен 1 месяц, с поля “Бюджет “,
     * если это другой статус этот параметр не использовать в запросе.
     *
     * @var string
     */
    private $value;

    /**
     * EventAnalytics constructor.
     * @param string $category
     * @param string $action
     * @param string $label
     * @param string $value
     */
    public function __construct(string $category, string $action, string $label, string $value)
    {
        $this->category = $category;
        $this->action = $action;
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
