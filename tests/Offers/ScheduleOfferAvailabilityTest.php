<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\ScheduleOfferAvailability;
use Cashback\Offers\ValueObjects\OfferID;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;
use DateTimeImmutable;

final class ScheduleOfferAvailabilityTest extends TestCase
{
    public function test_schedule_is_a_noop_but_accepts_arguments(): void
    {
        $repository = new InMemoryOfferRepository();
        $action = new ScheduleOfferAvailability($repository);

        $offerId = new OfferID('offer-1');
        $start = new DateTimeImmutable('2024-01-01T00:00:00Z');
        $end = new DateTimeImmutable('2024-02-01T00:00:00Z');

        // This action is an architectural placeholder; we just ensure it can
        // be called with correctly-typed arguments and does not throw.
        $action->schedule($offerId, $start, $end);

        $this->assertTrue(true);
    }
}

