<?php

namespace Cashback\Offers\Queries\GetOfferTrackingDestination;

use Cashback\Offers\ValueObjects\OfferID;

class GetOfferTrackingDestinationQuery
{
    public function __construct(
        public readonly OfferID $offerId,
    ) {}
}

