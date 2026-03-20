<?php

namespace Cashback\Offers\Contracts\Queries;

use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\GetOfferDetailsQuery;

interface GetOfferDetailsQueryHandler
{
    public function handle(GetOfferDetailsQuery $query): ?OfferData;
}
