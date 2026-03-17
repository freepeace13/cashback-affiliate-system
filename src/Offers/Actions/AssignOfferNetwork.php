<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\AssignOfferNetworkAction;
use Cashback\Offers\Repositories\OfferRepository;
use Cashback\Offers\ValueObjects\NetworkID;
use Cashback\Offers\ValueObjects\OfferID;

class AssignOfferNetwork implements AssignOfferNetworkAction
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    public function assign(OfferID $offerId, NetworkID $networkId): void
    {
        // Similar to AssignOfferMerchant, this action documents the intent of
        // associating an offer to a network. The concrete infrastructure
        // repository can choose how this is persisted.
    }
}

