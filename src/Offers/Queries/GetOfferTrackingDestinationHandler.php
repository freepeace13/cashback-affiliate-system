<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\GetOfferTrackingDestinationQueryHandler;
use Cashback\Offers\DTOs\Queries\GetOfferTrackingDestinationQuery;
use Cashback\Offers\Repositories\OfferQueryRepository;

class GetOfferTrackingDestinationHandler implements GetOfferTrackingDestinationQueryHandler
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
    ) {}

    public function handle(GetOfferTrackingDestinationQuery $query): ?string
    {
        $offer = $this->offerQueries->find($query->offerId);

        if ($offer === null) {
            return null;
        }

        return $offer->trackingUrl();
    }
}
