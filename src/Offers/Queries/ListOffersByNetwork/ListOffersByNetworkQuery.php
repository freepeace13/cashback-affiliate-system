<?php

namespace CashbackAffiliateSystem\Offers\Queries\ListOffersByNetwork;

use CashbackAffiliateSystem\Offers\ValueObjects\NetworkID;

class ListOffersByNetworkQuery
{
    public function __construct(
        public readonly NetworkID $networkId,
    ) {}
}

