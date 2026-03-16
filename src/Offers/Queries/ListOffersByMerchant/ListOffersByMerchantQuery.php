<?php

namespace CashbackAffiliateSystem\Offers\Queries\ListOffersByMerchant;

use CashbackAffiliateSystem\Offers\ValueObjects\MerchantID;

class ListOffersByMerchantQuery
{
    public function __construct(
        public readonly MerchantID $merchantId,
    ) {}
}

