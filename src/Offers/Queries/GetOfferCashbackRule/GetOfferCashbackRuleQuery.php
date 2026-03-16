<?php

namespace CashbackAffiliateSystem\Offers\Queries\GetOfferCashbackRule;

class GetOfferCashbackRuleQuery
{
    public function __construct(
        public readonly int|string $offerId,
    ) {}
}

