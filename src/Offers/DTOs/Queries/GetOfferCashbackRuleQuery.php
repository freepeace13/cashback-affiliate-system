<?php

namespace Cashback\Offers\DTOs\Queries;

class GetOfferCashbackRuleQuery
{
    public function __construct(
        public readonly int|string $offerId,
    ) {}
}
