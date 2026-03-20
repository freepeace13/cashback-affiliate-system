<?php

namespace Cashback\Offers\Contracts\Actions;

use DateTimeInterface;

interface SchedulesOffersAvailabilityAction
{
    public function schedule(
        int $offerId,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate,
    ): void;
}