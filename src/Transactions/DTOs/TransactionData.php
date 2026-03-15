<?php

namespace CashbackAffiliateSystem\Transactions\DTOs;

class TransactionData
{
    public function __construct(
        public readonly string $id,
        public readonly string $status,
        public readonly int $orderAmountInMinor,
        public readonly int $cashbackAmountInMinor,
        public readonly string $currency,
        public readonly ?string $trackedAt,
        public readonly ?string $confirmedAt,
    ) {}
}