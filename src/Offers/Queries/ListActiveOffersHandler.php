<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\ListActiveOffersQueryHandler;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListActiveOffersQuery;
use Cashback\Offers\Repositories\OfferQueryRepository;
use Cashback\Offers\Services\OfferListProjector;

class ListActiveOffersHandler implements ListActiveOffersQueryHandler
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
        private OfferListProjector $offerListProjector,
    ) {}

    /**
     * @return OfferData[]
     */
    public function handle(ListActiveOffersQuery $query): array
    {
        return $this->offerListProjector->toDataList(
            $this->offerQueries->listActiveOffers()
        );
    }
}
