<?php

namespace CashbackAffiliateSystem\Offers\Actions;

use CashbackAffiliateSystem\Offers\Contracts\AssignOfferNetworkAction;
use CashbackAffiliateSystem\Offers\Repositories\OfferRepository;
use CashbackAffiliateSystem\Offers\ValueObjects\NetworkID;
use CashbackAffiliateSystem\Offers\ValueObjects\OfferID;

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

