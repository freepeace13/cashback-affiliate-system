<?php

namespace CashbackAffiliateSystem\Tracking\DTOs;

final class CreateClickData
{
    public function __construct(
        public readonly string $userId,
        public readonly string $merchantId,
        public readonly string $offerId,
    ) {}
}