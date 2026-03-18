<?php

namespace Cashback\Offers\Contracts;

use Cashback\Offers\DTOs\MerchantData;

interface UpdatesMerchantAction
{
    public function update(MerchantData $data): MerchantData;
}
