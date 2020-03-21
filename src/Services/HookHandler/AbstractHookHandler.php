<?php

namespace App\Services\HookHandler;

use App\Entity\Amo\AmoData;

/**
 * Class AbstractHookHandler
 * @package App\Services\HookHandler
 */
abstract class AbstractHookHandler implements HookHandlerInterface
{
    /**
     * @var HookHandlerInterface
     */
    protected $next;

    /**
     * @param HookHandlerInterface $next
     */
    public function setNext(HookHandlerInterface $next): void
    {
        $this->next = $next;
    }

    /**
     * @param AmoData $data
     */
    public function handle(AmoData $data): void
    {
        if ($this->next) {
            $this->next->handle($data);
        }
    }
}
