<?php

namespace Cashback\Tracking\DTOs\Actions;

final class CreateClickData
{
    public function __construct(
        public readonly string $userId,
        public readonly string $merchantId,
        public readonly string $offerId,
        public readonly string $affiliateNetworkId,
        public readonly string $destinationUrl,
        public readonly string $trackingUrl,
    ) {}
}
