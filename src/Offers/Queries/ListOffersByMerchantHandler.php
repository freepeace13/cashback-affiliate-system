<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\ListOffersByMerchantQueryHandler;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListOffersByMerchantQuery;
use Cashback\Offers\Repositories\OfferQueryRepository;
use Cashback\Offers\Services\OfferListProjector;

class ListOffersByMerchantHandler implements ListOffersByMerchantQueryHandler
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
        private OfferListProjector $offerListProjector,
    ) {}

    /**
     * @return OfferData[]
     */
    public function handle(ListOffersByMerchantQuery $query): array
    {
        return $this->offerListProjector->toDataList(
            $this->offerQueries->listMerchantOffers($query->merchantId)
        );
    }
}
