<?php

namespace Cashback\Offers\Repositories;

use Cashback\Offers\Entities\Offer;

/**
 * Write persistence port for offers (interface segregation: command side).
 */
interface OfferCommandRepository
{
    public function create(Offer $offer): Offer;

    public function update(Offer $offer): void;
}
