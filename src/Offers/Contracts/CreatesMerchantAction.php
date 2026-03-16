<?php

namespace CashbackAffiliateSystem\Offers\Contracts;

use CashbackAffiliateSystem\Offers\DTOs\MerchantData;

interface CreatesMerchantAction
{
    public function create(MerchantData $data): MerchantData;
}