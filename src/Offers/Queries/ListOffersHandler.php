<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\ListOffersQueryHandler;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListOffersQuery;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Mappers\OfferEntityMapper;
use Cashback\Offers\Repositories\OfferRepository;

class ListOffersHandler implements ListOffersQueryHandler
{
    public function __construct(
        private OfferRepository $offerRepository,
        private OfferEntityMapper $offerEntityMapper,
    ) {}

    /**
     * @return OfferData[]
     */
    public function handle(ListOffersQuery $query): array
    {
        $offers = $this->offerRepository->listActiveOffers();

        return array_map(
            fn (Offer $offer): OfferData => $this->offerEntityMapper->mapEntityToData($offer),
            $offers
        );
    }
}
