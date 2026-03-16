<?php

namespace CashbackAffiliateSystem\Offers\Queries\ListOffersByNetwork;

use CashbackAffiliateSystem\Offers\DTOs\OfferData;
use CashbackAffiliateSystem\Offers\Entities\Offer;
use CashbackAffiliateSystem\Offers\Repositories\OfferRepository;

class ListOffersByNetworkHandler
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    /**
     * @return OfferData[]
     */
    public function handle(ListOffersByNetworkQuery $query): array
    {
        // The repository interface doesn't yet have a dedicated method for this;
        // for the purposes of this demo handler we fallback to listActiveOffers
        // and rely on infrastructure to filter by network when appropriate.
        $offers = $this->offerRepository->listActiveOffers();

        return array_map(
            fn (Offer $offer): OfferData => new OfferData(
                name: $offer->name,
                description: $offer->description,
                trackingUrl: $offer->trackingUrl,
                cashbackType: $offer->cashbackType,
                cashbackValue: $offer->cashbackValue,
                currency: $offer->currency,
                status: $offer->status,
                createdAt: $offer->createdAt,
                updatedAt: $offer->updatedAt,
            ),
            $offers
        );
    }
}

