<?php

namespace Cashback\Offers\Contracts\Queries;

use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListAvailableOffersQuery;

interface ListAvailableOffersQueryHandler
{
    /**
     * @return OfferData[]
     */
    public function handle(ListAvailableOffersQuery $query): array;
}
