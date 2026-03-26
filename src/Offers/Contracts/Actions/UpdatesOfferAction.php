<?php

namespace Cashback\Offers\Contracts\Actions;

use Cashback\Offers\DTOs\Actions\UpdateOfferData;
use Cashback\Offers\DTOs\OfferData;

interface UpdatesOfferAction
{
    public function update(int $offerId, UpdateOfferData $data): OfferData;
}
