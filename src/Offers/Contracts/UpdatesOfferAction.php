<?php

namespace CashbackAffiliateSystem\Offers\Contracts;

use CashbackAffiliateSystem\Offers\DTOs\OfferData;
use CashbackAffiliateSystem\Offers\ValueObjects\OfferID;

interface UpdatesOfferAction
{
    public function update(OfferID $id, OfferData $data): OfferData;
}