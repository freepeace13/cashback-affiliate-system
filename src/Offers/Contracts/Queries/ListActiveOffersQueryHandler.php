<?php

namespace Cashback\Offers\Contracts\Queries;

use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListActiveOffersQuery;

interface ListActiveOffersQueryHandler
{
    /**
     * @return OfferData[]
     */
    public function handle(ListActiveOffersQuery $query): array;
}
