<?php

namespace CashbackAffiliateSystem\Offers\Contracts;

use CashbackAffiliateSystem\Offers\DTOs\MerchantData;
use CashbackAffiliateSystem\Offers\ValueObjects\MerchantID;

interface UpdatesMerchantAction
{
    public function update(MerchantID $id, MerchantData $data): MerchantData;
}