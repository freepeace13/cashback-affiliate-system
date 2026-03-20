<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\ListOffersByMerchantQueryHandler;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListOffersByMerchantQuery;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Mappers\OfferEntityMapper;
use Cashback\Offers\Repositories\OfferRepository;

class ListOffersByMerchantHandler implements ListOffersByMerchantQueryHandler
{
    public function __construct(
        private OfferRepository $offerRepository,
        private OfferEntityMapper $offerEntityMapper,
    ) {}

    /**
     * @return OfferData[]
     */
    public function handle(ListOffersByMerchantQuery $query): array
    {
        $offers = $this->offerRepository->listMerchantOffers($query->merchantId);

        return array_map(
            fn (Offer $offer): OfferData => $this->offerEntityMapper->mapEntityToData($offer),
            $offers
        );
    }
}
