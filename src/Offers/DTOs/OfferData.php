<?php

namespace Cashback\Offers\DTOs;

final class OfferData
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly string $trackingUrl,
        public readonly string $cashbackType,
        public readonly string $cashbackValue,
        public readonly string $currency,
        public readonly string $status,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {}
}