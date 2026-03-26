<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\SchedulesOffersAvailabilityAction;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Exceptions\OfferNotFound;
use Cashback\Offers\Repositories\OfferCommandRepository;
use Cashback\Offers\Repositories\OfferQueryRepository;
use Cashback\Offers\Services\DateTimeToImmutable;
use Cashback\Offers\Value\DateRange;
use DateTimeInterface;

class ScheduleOfferAvailabilityAction implements SchedulesOffersAvailabilityAction
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
        private OfferCommandRepository $offerCommands,
    ) {}

    public function schedule(int $offerId, DateRange $schedule): void
    {
        $offer = $this->offerQueries->find($offerId);
        if ($offer === null) {
            throw new OfferNotFound("Offer {$offerId} not found");
        }

        $this->offerCommands->update(
            $offer->withSchedule($schedule->startsAt(), $schedule->endsAt())
        );
    }
}
