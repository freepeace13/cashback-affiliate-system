<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\ListOffersQueryHandler;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListOffersQuery;
use Cashback\Offers\Repositories\OfferQueryRepository;
use Cashback\Offers\Services\OfferListProjector;

class ListOffersHandler implements ListOffersQueryHandler
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
        private OfferListProjector $offerListProjector,
    ) {}

    /**
     * @return OfferData[]
     */
    public function handle(ListOffersQuery $query): array
    {
        return $this->offerListProjector->toDataList(
            $this->offerQueries->listActiveOffers()
        );
    }
}
