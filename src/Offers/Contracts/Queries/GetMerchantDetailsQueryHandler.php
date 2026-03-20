<?php

namespace Cashback\Offers\Contracts\Queries;

use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\DTOs\Queries\GetMerchantDetailsQuery;

interface GetMerchantDetailsQueryHandler
{
    public function handle(GetMerchantDetailsQuery $query): ?MerchantData;
}
