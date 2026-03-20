<?php

namespace Cashback\Offers\DTOs\Queries;

class GetOfferTrackingDestinationQuery
{
    public function __construct(
        public readonly int $offerId,
    ) {}
}
