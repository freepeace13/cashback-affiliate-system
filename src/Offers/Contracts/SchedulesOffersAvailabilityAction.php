<?php

namespace Cashback\Offers\Contracts; 

use Cashback\Offers\ValueObjects\OfferID;
use DateTimeInterface;

interface SchedulesOffersAvailabilityAction
{
    public function schedule(
        OfferID $id,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate,
    ): void;
}