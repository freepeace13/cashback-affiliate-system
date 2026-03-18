<?php

namespace Cashback\Offers\Queries\ListOffersByMerchant;

use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Repositories\OfferRepository;

class ListOffersByMerchantHandler
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    /**
     * @return OfferData[]
     */
    public function handle(ListOffersByMerchantQuery $query): array
    {
        $offers = $this->offerRepository->listMerchantOffers($query->merchantId);

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

