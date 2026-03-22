<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\AssignOfferNetworkAction as AssignOfferNetworkActionContract;
use Cashback\Offers\Exceptions\OfferNotFound;
use Cashback\Offers\Repositories\OfferCommandRepository;
use Cashback\Offers\Repositories\OfferQueryRepository;

class AssignOfferNetworkAction implements AssignOfferNetworkActionContract
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
        private OfferCommandRepository $offerCommands,
    ) {}

    public function assign(int $offerId, int $networkId): void
    {
        $offer = $this->offerQueries->find($offerId);
        if ($offer === null) {
            throw new OfferNotFound("Offer {$offerId} not found");
        }

        $this->offerCommands->update($offer->withAffiliateNetworkId($networkId));
    }
}
