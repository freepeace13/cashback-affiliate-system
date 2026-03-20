<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\ListAvailableOffersQueryHandler;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListAvailableOffersQuery;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Mappers\OfferEntityMapper;
use Cashback\Offers\Repositories\OfferRepository;

class ListAvailableOffersHandler implements ListAvailableOffersQueryHandler
{
    public function __construct(
        private OfferRepository $offerRepository,
        private OfferEntityMapper $offerEntityMapper,
    ) {}

    /**
     * @return OfferData[]
     */
    public function handle(ListAvailableOffersQuery $query): array
    {
        $offers = $this->offerRepository->listAvailableOffers();

        return array_map(
            fn (Offer $offer): OfferData => $this->offerEntityMapper->mapEntityToData($offer),
            $offers
        );
    }
}
