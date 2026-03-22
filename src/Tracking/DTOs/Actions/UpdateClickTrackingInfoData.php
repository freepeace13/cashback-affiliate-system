<?php

namespace Cashback\Tracking\DTOs\Actions;

final class UpdateClickTrackingInfoData
{
    public function __construct(
        public readonly string $clickRef,
        public readonly ?string $deviceType,
        public readonly ?string $userAgent,
        public readonly ?string $ipAddress,
    ) {}
}
