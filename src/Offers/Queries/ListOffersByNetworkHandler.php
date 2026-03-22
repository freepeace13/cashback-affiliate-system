<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\ListOffersByNetworkQueryHandler;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListOffersByNetworkQuery;
use Cashback\Offers\Repositories\OfferQueryRepository;
use Cashback\Offers\Services\OfferListProjector;

class ListOffersByNetworkHandler implements ListOffersByNetworkQueryHandler
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
        private OfferListProjector $offerListProjector,
    ) {}

    /**
     * @return OfferData[]
     */
    public function handle(ListOffersByNetworkQuery $query): array
    {
        return $this->offerListProjector->toDataList(
            $this->offerQueries->listOffersByAffiliateNetwork($query->networkId)
        );
    }
}
