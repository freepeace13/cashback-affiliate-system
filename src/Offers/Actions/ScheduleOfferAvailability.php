<?php

namespace CashbackAffiliateSystem\Offers\Actions;

use CashbackAffiliateSystem\Offers\Contracts\SchedulesOffersAvailabilityAction;
use CashbackAffiliateSystem\Offers\Repositories\OfferRepository;
use CashbackAffiliateSystem\Offers\ValueObjects\OfferID;
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

