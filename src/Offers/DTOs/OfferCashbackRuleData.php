<?php

namespace Cashback\Offers\DTOs;

final class OfferCashbackRuleData
{
    public function __construct(
        public readonly string $cashbackType,
        public readonly string $cashbackValue,
        public readonly string $currency,
    ) {}
}
