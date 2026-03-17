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
            name: $offer->name,
            description: $offer->description,
            trackingUrl: $offer->trackingUrl,
            cashbackType: $offer->cashbackType,
            cashbackValue: $offer->cashbackValue,
            currency: $offer->currency,
            status: $offer->status,
            createdAt: $offer->createdAt,
            updatedAt: $offer->updatedAt,
        );
    }
}

