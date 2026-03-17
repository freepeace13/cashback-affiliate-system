<?php

namespace Cashback\Offers\Queries\ListOffersByMerchant;

use Cashback\Offers\ValueObjects\MerchantID;

class ListOffersByMerchantQuery
{
    public function __construct(
        public readonly MerchantID $merchantId,
    ) {}
}

