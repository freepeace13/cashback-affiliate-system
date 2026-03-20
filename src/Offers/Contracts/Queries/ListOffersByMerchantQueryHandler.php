<?php

namespace Cashback\Offers\Contracts\Queries;

use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListOffersByMerchantQuery;

interface ListOffersByMerchantQueryHandler
{
    /**
     * @return OfferData[]
     */
    public function handle(ListOffersByMerchantQuery $query): array;
}
