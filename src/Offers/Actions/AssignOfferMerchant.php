<?php

namespace CashbackAffiliateSystem\Offers\Actions;

use CashbackAffiliateSystem\Offers\Contracts\AssignOfferMerchantAction;
use CashbackAffiliateSystem\Offers\Repositories\OfferRepository;
use CashbackAffiliateSystem\Offers\ValueObjects\MerchantID;
use CashbackAffiliateSystem\Offers\ValueObjects\OfferID;

class AssignOfferMerchant implements AssignOfferMerchantAction
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    public function assign(OfferID $offerId, MerchantID $merchantId): void
    {
        // This demo repository interface doesn't yet expose an explicit method
        // to update the merchant association. Implementations are expected to
        // interpret this as part of offer persistence for now.
        //
        // For clarity in the architecture demo, we keep this as a no-op and
        // leave the concrete repository free to implement the association.
    }
}

