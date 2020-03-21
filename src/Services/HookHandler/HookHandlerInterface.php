<?php

namespace App\Services\HookHandler;

use App\Entity\Amo\AmoData;

/**
 * Interface HookHandlerInterface
 * @package App\Services\HookHandler
 */
interface HookHandlerInterface
{
    /**
     * @param HookHandlerInterface $next
     */
    public function setNext(HookHandlerInterface $next): void;

    /**
     * @param AmoData $data
     */
    public function handle(AmoData $data): void;
}
