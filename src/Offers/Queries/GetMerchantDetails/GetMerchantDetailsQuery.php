<?php

namespace CashbackAffiliateSystem\Offers\Queries\GetMerchantDetails;

class GetMerchantDetailsQuery
{
    public function __construct(
        public readonly int|string $merchantId,
    ) {}
}
