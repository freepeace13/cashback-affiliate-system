<?php

namespace Cashback\Offers\Contracts;

use Cashback\Offers\ValueObjects\OfferID;
use Cashback\Offers\ValueObjects\NetworkID;

interface AssignOfferNetworkAction
{
    public function assign(OfferID $offerId, NetworkID $networkId): void;
}