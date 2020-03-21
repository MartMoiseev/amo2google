<?php

namespace App\Entity\Amo;

/**
 * Class AmoUtm
 * @package App\Entity\Amo
 */
class AmoUtm
{
    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $medium;

    /**
     * @var string
     */
    private $campaign;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $term;

    /**
     * @var string
     */
    private $clientId;

    /**
     * AmoUtm constructor.
     * @param string $source
     * @param string $medium
     * @param string $campaign
     * @param string $content
     * @param string $term
     * @param string $clientId
     */
    public function __construct(string $source, string $medium, string $campaign, string $content, string $term, string $clientId)
    {
        $this->source = $source;
        $this->medium = $medium;
        $this->campaign = $campaign;
        $this->content = $content;
        $this->term = $term;
        $this->clientId = $clientId;
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
    public function getCampaign(): string
    {
        return $this->campaign;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getTerm(): string
    {
        return $this->term;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }
}
