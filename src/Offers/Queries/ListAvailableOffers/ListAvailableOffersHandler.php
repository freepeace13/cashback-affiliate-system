<?php

namespace Cashback\Offers\Queries\ListAvailableOffers;

use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Repositories\OfferRepository;

class ListAvailableOffersHandler
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    /**
     * @return OfferData[]
     */
    public function handle(ListAvailableOffersQuery $query): array
    {
        $offers = $this->offerRepository->listAvailableOffers();

        return array_map(
            fn (Offer $offer): OfferData => new OfferData(
                name: $offer->title(),
                description: $offer->description() ?? '',
                trackingUrl: $offer->trackingUrl(),
                cashbackType: $offer->cashbackType(),
                cashbackValue: (string) $offer->cashbackValue(),
                currency: $offer->currency(),
                status: $offer->status()->value(),
                createdAt: '',
                updatedAt: '',
            ),
            $offers
        );
    }
}

