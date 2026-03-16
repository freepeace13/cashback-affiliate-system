<?php

namespace CashbackAffiliateSystem\Offers\Contracts;

use CashbackAffiliateSystem\Offers\ValueObjects\OfferID;
use CashbackAffiliateSystem\Offers\ValueObjects\NetworkID;

interface AssignOfferNetworkAction
{
    public function assign(OfferID $offerId, NetworkID $networkId): void;
}