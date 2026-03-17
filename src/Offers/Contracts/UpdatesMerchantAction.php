<?php

namespace Cashback\Offers\Contracts;

use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\ValueObjects\MerchantID;

interface UpdatesMerchantAction
{
    public function update(MerchantID $id, MerchantData $data): MerchantData;
}