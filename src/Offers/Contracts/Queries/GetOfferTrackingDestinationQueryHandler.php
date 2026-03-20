<?php

namespace Cashback\Offers\Contracts\Queries;

use Cashback\Offers\DTOs\Queries\GetOfferTrackingDestinationQuery;

interface GetOfferTrackingDestinationQueryHandler
{
    public function handle(GetOfferTrackingDestinationQuery $query): ?string;
}
