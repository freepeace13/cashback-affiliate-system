<?php

namespace Cashback\Offers\Contracts\Queries;

use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListOffersByNetworkQuery;

interface ListOffersByNetworkQueryHandler
{
    /**
     * @return OfferData[]
     */
    public function handle(ListOffersByNetworkQuery $query): array;
}
