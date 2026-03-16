<?php

namespace CashbackAffiliateSystem\Offers\Contracts; 

use CashbackAffiliateSystem\Offers\ValueObjects\OfferID;
use DateTimeInterface;

interface SchedulesOffersAvailabilityAction
{
    public function schedule(
        OfferID $id,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate,
    ): void;
}