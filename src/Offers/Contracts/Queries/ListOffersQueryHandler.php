<?php

namespace Cashback\Offers\Contracts\Queries;

use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListOffersQuery;

interface ListOffersQueryHandler
{
    /**
     * @return OfferData[]
     */
    public function handle(ListOffersQuery $query): array;
}
