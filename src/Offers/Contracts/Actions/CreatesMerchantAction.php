<?php

namespace Cashback\Offers\Contracts\Actions;

use Cashback\Offers\DTOs\Actions\CreateMerchantData;
use Cashback\Offers\DTOs\MerchantData;

interface CreatesMerchantAction
{
    public function create(CreateMerchantData $data): MerchantData;
}
