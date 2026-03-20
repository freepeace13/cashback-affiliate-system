<?php

namespace Cashback\Offers\Contracts\Actions;

use Cashback\Offers\DTOs\Actions\CreateOfferData;
use Cashback\Offers\DTOs\OfferData;

interface CreatesOfferAction
{
    public function create(CreateOfferData $data): OfferData;
}
