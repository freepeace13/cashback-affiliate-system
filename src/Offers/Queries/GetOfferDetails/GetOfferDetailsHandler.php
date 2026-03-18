<?php

namespace Cashback\Offers\Queries\GetOfferDetails;

use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Repositories\OfferRepository;
use Cashback\Offers\ValueObjects\OfferID;

class GetOfferDetailsHandler
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    public function handle(GetOfferDetailsQuery $query): ?OfferData
    {
        $identifier = $query->offerId;

        if (!is_int($identifier) && !ctype_digit((string) $identifier)) {
            // If slug-based lookup is supported in the repository, it can be added later.
            return null;
        }

        $offer = $this->offerRepository->find(new OfferID((string) $identifier));

        if ($offer === null) {
            return null;
        }

        return new OfferData(
            name: $offer->title(),
            description: $offer->description() ?? '',
            trackingUrl: $offer->trackingUrl(),
            cashbackType: $offer->cashbackType(),
            cashbackValue: (string) $offer->cashbackValue(),
            currency: $offer->currency(),
            status: $offer->status()->value(),
            createdAt: '',
            updatedAt: '',
            merchantId: $offer->merchantId(),
            affiliateNetworkId: $offer->affiliateNetworkId(),
        );
    }
}

