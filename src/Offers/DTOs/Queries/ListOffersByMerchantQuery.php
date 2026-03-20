<?php

namespace Cashback\Offers\DTOs\Queries;

class ListOffersByMerchantQuery
{
    public function __construct(
        public readonly int $merchantId,
    ) {}
}
