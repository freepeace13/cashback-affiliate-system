<?php

namespace Cashback\Offers\Queries\GetOfferDetails;

class GetOfferDetailsQuery
{
    public function __construct(
        public readonly int|string $offerId,
    ) {}
}
