<?php

namespace Cashback\Offers\DTOs;

final class MerchantData
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly string $websiteUrl,
        public readonly string $logoUrl,
        public readonly string $status,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {}
}