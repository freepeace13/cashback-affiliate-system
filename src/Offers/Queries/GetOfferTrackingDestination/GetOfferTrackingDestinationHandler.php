<?php

namespace CashbackAffiliateSystem\Offers\Queries\GetOfferTrackingDestination;

use CashbackAffiliateSystem\Offers\Repositories\OfferRepository;

class GetOfferTrackingDestinationHandler
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    public function handle(GetOfferTrackingDestinationQuery $query): ?string
    {
        $offer = $this->offerRepository->find($query->offerId);

        if ($offer === null) {
            return null;
        }

        return $offer->trackingUrl;
    }
}

