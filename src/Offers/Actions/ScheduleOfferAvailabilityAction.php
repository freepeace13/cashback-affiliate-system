<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\SchedulesOffersAvailabilityAction;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Exceptions\OfferNotFound;
use Cashback\Offers\Repositories\OfferCommandRepository;
use Cashback\Offers\Repositories\OfferQueryRepository;
use Cashback\Offers\Services\DateTimeToImmutable;
use DateTimeInterface;

class ScheduleOfferAvailabilityAction implements SchedulesOffersAvailabilityAction
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
        private OfferCommandRepository $offerCommands,
    ) {}

    public function schedule(
        int $offerId,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate,
    ): void {
        $offer = $this->offerQueries->find($offerId);
        if ($offer === null) {
            throw new OfferNotFound("Offer {$offerId} not found");
        }

        $start = DateTimeToImmutable::convert($startDate);
        $end = DateTimeToImmutable::convert($endDate);

        Offer::ensureValidAvailabilityWindow($start, $end);

        $this->offerCommands->update($offer->withSchedule($start, $end));
    }
}
