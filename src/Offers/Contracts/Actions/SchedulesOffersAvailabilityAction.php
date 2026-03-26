<?php

namespace Cashback\Offers\Contracts\Actions;

use Cashback\Offers\Value\DateRange;

interface SchedulesOffersAvailabilityAction
{
    public function schedule(int $offerId, DateRange $schedule): void;
}
