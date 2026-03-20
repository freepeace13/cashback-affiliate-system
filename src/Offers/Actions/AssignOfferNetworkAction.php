<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\AssignOfferNetworkAction as AssignOfferNetworkActionContract;
use Cashback\Offers\Repositories\OfferRepository;

class AssignOfferNetworkAction implements AssignOfferNetworkActionContract
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    public function assign(int $offerId, int $networkId): void
    {
        // Similar to AssignOfferMerchant, this action documents the intent of
        // associating an offer to a network. The concrete infrastructure
        // repository can choose how this is persisted.
    }
}
