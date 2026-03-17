<?php

namespace Cashback\Offers\Contracts;

use Cashback\Offers\DTOs\OfferData;

interface CreatesOfferAction
{
    public function create(OfferData $data): OfferData;
}