<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\AssignOfferMerchantAction as AssignOfferMerchantActionContract;
use Cashback\Offers\Repositories\OfferRepository;

class AssignOfferMerchantAction implements AssignOfferMerchantActionContract
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    public function assign(int $offerId, int $merchantId): void
    {
        // This demo repository interface doesn't yet expose an explicit method
        // to update the merchant association. Implementations are expected to
        // interpret this as part of offer persistence for now.
        //
        // For clarity in the architecture demo, we keep this as a no-op and
        // leave the concrete repository free to implement the association.
    }
}
