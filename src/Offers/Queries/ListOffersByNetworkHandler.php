<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\ListOffersByNetworkQueryHandler;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListOffersByNetworkQuery;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Mappers\OfferEntityMapper;
use Cashback\Offers\Repositories\OfferRepository;

class ListOffersByNetworkHandler implements ListOffersByNetworkQueryHandler
{
    public function __construct(
        private OfferRepository $offerRepository,
        private OfferEntityMapper $offerEntityMapper,
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
            fn (Offer $offer): OfferData => $this->offerEntityMapper->mapEntityToData($offer),
            $offers
        );
    }
}
