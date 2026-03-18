<?php

namespace Cashback\Offers\Contracts;

use Cashback\Offers\DTOs\OfferData;

interface UpdatesOfferAction
{
    public function update(OfferData $data): OfferData;
}
