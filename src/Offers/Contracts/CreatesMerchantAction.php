<?php

namespace Cashback\Offers\Contracts;

use Cashback\Offers\DTOs\MerchantData;

interface CreatesMerchantAction
{
    public function create(MerchantData $data): MerchantData;
}