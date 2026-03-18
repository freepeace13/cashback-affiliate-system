<?php

namespace Cashback\Tracking\Repositories;

use Cashback\Tracking\Entities\Click;

interface ClickRepository
{
    public function find(string $id): ?Click;

    public function save(Click $click): Click;

    public function attachUser(string $clickRef, string $userId): void;

    public function registerExternalRef(string $clickRef, string $externalClickRef): void;

    /**
     * @param array<string,mixed> $metadata
     */
    public function updateMetadata(string $clickRef, array $metadata): void;

    public function updateTrackingInfo(
        string $clickRef,
        ?string $deviceType,
        ?string $userAgent,
        ?string $ipAddress,
    ): void;
}

