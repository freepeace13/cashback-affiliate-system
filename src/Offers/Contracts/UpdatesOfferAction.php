<?php

namespace Cashback\Offers\Contracts;

use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\ValueObjects\OfferID;

interface UpdatesOfferAction
{
    public function update(OfferID $id, OfferData $data): OfferData;
}