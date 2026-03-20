<?php

namespace Cashback\Offers\DTOs\Queries;

class GetOfferDetailsQuery
{
    public function __construct(
        public readonly int|string $offerId,
    ) {}
}
