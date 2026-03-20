<?php

namespace Cashback\Offers\DTOs\Queries;

class ListOffersByNetworkQuery
{
    public function __construct(
        public readonly int $networkId,
    ) {}
}
