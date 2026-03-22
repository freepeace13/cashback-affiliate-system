<?php

namespace Cashback\Tracking\DTOs;

final class ClickData
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $clickRef = '',
        public readonly int $merchantId = 0,
        public readonly int $offerId = 0,
        public readonly int $affiliateNetworkId = 0,
        public readonly string $destinationUrl = '',
        public readonly string $trackingUrl = '',
        public readonly \DateTimeImmutable $clickedAt = new \DateTimeImmutable(),
    ) {}
}
