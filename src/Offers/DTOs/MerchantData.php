<?php

namespace Cashback\Offers\DTOs;

final class MerchantData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $websiteUrl,
        public readonly ?string $logoUrl,
        public readonly string $status,
    ) {}
}
