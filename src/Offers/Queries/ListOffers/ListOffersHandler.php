<?php

namespace CashbackAffiliateSystem\Offers\Queries\ListOffers;

use CashbackAffiliateSystem\Offers\DTOs\OfferData;
use CashbackAffiliateSystem\Offers\Entities\Offer;
use CashbackAffiliateSystem\Offers\Repositories\OfferRepository;

class ListOffersHandler
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    /**
     * @return OfferData[]
     */
    public function handle(ListOffersQuery $query): array
    {
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

