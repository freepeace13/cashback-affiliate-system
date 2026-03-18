<?php

namespace Cashback\Offers\Queries\GetOfferTrackingDestination;

use Cashback\Offers\Repositories\OfferRepository;

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

        return $offer->trackingUrl();
    }
}

