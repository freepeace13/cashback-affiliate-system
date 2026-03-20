<?php

namespace Cashback\Offers\DTOs\Queries;

class GetMerchantDetailsQuery
{
    public function __construct(
        public readonly int|string $merchantId,
    ) {}
}
