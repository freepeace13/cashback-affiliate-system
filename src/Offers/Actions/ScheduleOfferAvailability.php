<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\SchedulesOffersAvailabilityAction;
use Cashback\Offers\Repositories\OfferRepository;
use Cashback\Offers\ValueObjects\OfferID;
use DateTimeInterface;

class ScheduleOfferAvailability implements SchedulesOffersAvailabilityAction
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    public function schedule(
        OfferID $id,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate,
    ): void {
        // This action is intentionally left as an architectural placeholder.
        // A real implementation would likely adjust status/validity windows
        // and rely on infrastructure to persist and enforce them.
    }
}

