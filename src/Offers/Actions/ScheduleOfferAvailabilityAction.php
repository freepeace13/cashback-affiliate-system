<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\SchedulesOffersAvailabilityAction;
use Cashback\Offers\Repositories\OfferRepository;
use DateTimeInterface;

class ScheduleOfferAvailabilityAction implements SchedulesOffersAvailabilityAction
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    public function schedule(
        int $offerId,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate,
    ): void {
        // This action is intentionally left as an architectural placeholder.
        // A real implementation would likely adjust status/validity windows
        // and rely on infrastructure to persist and enforce them.
    }
}
