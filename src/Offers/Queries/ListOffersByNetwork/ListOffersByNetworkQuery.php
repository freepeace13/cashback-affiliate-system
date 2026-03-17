<?php

namespace Cashback\Offers\Queries\ListOffersByNetwork;

use Cashback\Offers\ValueObjects\NetworkID;

class ListOffersByNetworkQuery
{
    public function __construct(
        public readonly NetworkID $networkId,
    ) {}
}

