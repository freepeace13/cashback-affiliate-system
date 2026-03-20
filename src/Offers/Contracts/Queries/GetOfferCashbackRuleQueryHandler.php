<?php

namespace Cashback\Offers\Contracts\Queries;

use Cashback\Offers\DTOs\OfferCashbackRuleData;
use Cashback\Offers\DTOs\Queries\GetOfferCashbackRuleQuery;

interface GetOfferCashbackRuleQueryHandler
{
    public function handle(GetOfferCashbackRuleQuery $query): ?OfferCashbackRuleData;
}
