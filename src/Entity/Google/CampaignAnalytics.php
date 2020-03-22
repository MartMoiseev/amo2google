<?php

namespace App\Entity\Google;

/**
 * Class CampaignAnalytics
 * @package App\Entity\Google
 */
class CampaignAnalytics
{
    /**
     * Источник трафика (поле utm_source из AmoCRM), передавать значения,
     * если разница даты и времени создания заявки и отправки на сервер больше чем 25 мин,
     * если разница меньше чем 25 мин - этот параметр не использовать в запросе.
     *
     * @var string
     */
    private $source;

    /**
     * Канал трафика (поле utm_medium из AmoCRM)
     * 25 минут
     *
     * @var string
     */
    private $medium;

    /**
     * Название кампании (поле utm_campaign из AmoCRM),
     * 25 минут
     *
     * @var string
     */
    private $name;

    /**
     * Ключевое слово кампании (поле utm_term из AmoCRM)
     * 25 минут
     *
     * @var string
     */
    private $keyword;

    /**
     * Содержание кампании (поле utm_content из AmoCRM)
     * 25 минут
     *
     * @var string
     */
    private $content;

    /**
     * CampaignAnalytics constructor.
     * @param string $source
     * @param string $medium
     * @param string $name
     * @param string $keyword
     * @param string $content
     */
    public function __construct(string $source, string $medium, string $name, string $keyword, string $content)
    {
        $this->source = $source;
        $this->medium = $medium;
        $this->name = $name;
        $this->keyword = $keyword;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getMedium(): string
    {
        return $this->medium;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getKeyword(): string
    {
        return $this->keyword;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'source' => $this->source,
            'medium' => $this->medium,
            'name' => $this->name,
            'keyword' => $this->keyword,
            'content' => $this->content,
        ];
    }
}
