<?php

namespace Cashback\Offers\Contracts\Actions;

use Cashback\Offers\DTOs\Actions\UpdateMerchantData;
use Cashback\Offers\DTOs\MerchantData;

interface UpdatesMerchantAction
{
    public function update(UpdateMerchantData $data): MerchantData;
}
