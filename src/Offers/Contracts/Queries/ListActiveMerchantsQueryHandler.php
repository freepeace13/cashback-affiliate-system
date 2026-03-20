<?php

namespace Cashback\Offers\Contracts\Queries;

use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\DTOs\Queries\ListActiveMerchantsQuery;

interface ListActiveMerchantsQueryHandler
{
    /**
     * @return MerchantData[]
     */
    public function handle(ListActiveMerchantsQuery $query): array;
}
