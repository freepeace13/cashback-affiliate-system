<?php

namespace CashbackAffiliateSystem\Payouts\Entities;

class PayoutRequest
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
    ) {}
}