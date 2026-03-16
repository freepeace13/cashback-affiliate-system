<?php

namespace CashbackAffiliateSystem\Offers\Queries\GetOfferTrackingDestination;

use CashbackAffiliateSystem\Offers\ValueObjects\OfferID;

class GetOfferTrackingDestinationQuery
{
    public function __construct(
        public readonly OfferID $offerId,
    ) {}
}

