<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\GetOfferTrackingDestinationQueryHandler;
use Cashback\Offers\DTOs\Queries\GetOfferTrackingDestinationQuery;
use Cashback\Offers\Repositories\OfferRepository;

class GetOfferTrackingDestinationHandler implements GetOfferTrackingDestinationQueryHandler
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
