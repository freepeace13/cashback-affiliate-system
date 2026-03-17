<?php

namespace Cashback\Offers\Contracts;

use Cashback\Offers\ValueObjects\OfferID;
use Cashback\Offers\ValueObjects\MerchantID;

interface AssignOfferMerchantAction
{
    public function assign(OfferID $offerId, MerchantID $merchantId): void;
}