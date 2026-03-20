<?php

namespace Cashback\Offers\Contracts\Actions;

interface AssignOfferMerchantAction
{
    public function assign(int $offerId, int $merchantId): void;
}