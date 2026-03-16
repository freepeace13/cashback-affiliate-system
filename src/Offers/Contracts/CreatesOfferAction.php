<?php

namespace CashbackAffiliateSystem\Offers\Contracts;

use CashbackAffiliateSystem\Offers\DTOs\OfferData;

interface CreatesOfferAction
{
    public function create(OfferData $data): OfferData;
}