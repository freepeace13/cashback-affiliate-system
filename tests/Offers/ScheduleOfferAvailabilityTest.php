<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\ScheduleOfferAvailabilityAction;
use Cashback\Offers\Exceptions\OfferNotFound;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;
use DateTimeImmutable;
use InvalidArgumentException;

final class ScheduleOfferAvailabilityTest extends TestCase
{
    public function test_it_persists_availability_window(): void
    {
        $repository = new InMemoryOfferRepository([$this->sampleOfferRow(1)]);
        $action = new ScheduleOfferAvailabilityAction($repository, $repository);

        $start = new DateTimeImmutable('2024-01-01T00:00:00Z');
        $end = new DateTimeImmutable('2024-02-01T00:00:00Z');

        $action->schedule(1, $start, $end);

        $updated = $repository->find(1);
        $this->assertNotNull($updated);
        $this->assertEquals($start, $updated->startsAt());
        $this->assertEquals($end, $updated->endsAt());
    }

    public function test_it_throws_when_offer_missing(): void
    {
        $repository = new InMemoryOfferRepository([]);
        $action = new ScheduleOfferAvailabilityAction($repository, $repository);

        $this->expectException(OfferNotFound::class);
        $action->schedule(
            99,
            new DateTimeImmutable('2024-01-01T00:00:00Z'),
            new DateTimeImmutable('2024-02-01T00:00:00Z'),
        );
    }

    public function test_it_rejects_inverted_window(): void
    {
        $repository = new InMemoryOfferRepository([$this->sampleOfferRow(1)]);
        $action = new ScheduleOfferAvailabilityAction($repository, $repository);

        $this->expectException(InvalidArgumentException::class);
        $action->schedule(
            1,
            new DateTimeImmutable('2024-02-01T00:00:00Z'),
            new DateTimeImmutable('2024-01-01T00:00:00Z'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function sampleOfferRow(int $id): array
    {
        return [
            'id' => $id,
            'merchant_id' => 1,
            'affiliate_network_id' => 1,
            'title' => 'T',
            'description' => null,
            'tracking_url' => 'https://track.example/r',
            'cashback_type' => 'percentage',
            'cashback_value' => 5.0,
            'currency' => 'USD',
            'status' => 'active',
            'starts_at' => null,
            'ends_at' => null,
        ];
    }
}
