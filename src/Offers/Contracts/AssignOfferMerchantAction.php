<?php

namespace CashbackAffiliateSystem\Offers\Contracts;

use CashbackAffiliateSystem\Offers\ValueObjects\OfferID;
use CashbackAffiliateSystem\Offers\ValueObjects\MerchantID;

interface AssignOfferMerchantAction
{
    public function assign(OfferID $offerId, MerchantID $merchantId): void;
}