<?php

namespace CashbackAffiliateSystem\Offers\Queries\GetOfferDetails;

use CashbackAffiliateSystem\Offers\DTOs\OfferData;
use CashbackAffiliateSystem\Offers\Repositories\OfferRepository;
use CashbackAffiliateSystem\Offers\ValueObjects\OfferID;

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

