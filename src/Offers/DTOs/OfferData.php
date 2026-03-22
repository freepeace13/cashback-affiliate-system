<?php

namespace Cashback\Offers\DTOs;

use DateTimeImmutable;

final class OfferData
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?string $description,
        public readonly string $trackingUrl,
        public readonly string $cashbackType,
        public readonly string $cashbackValue,
        public readonly string $currency,
        public readonly string $status,
        public readonly int $merchantId = 0,
        public readonly int $affiliateNetworkId = 0,
        public readonly ?DateTimeImmutable $startsAt = null,
        public readonly ?DateTimeImmutable $endsAt = null,
    ) {}
}
