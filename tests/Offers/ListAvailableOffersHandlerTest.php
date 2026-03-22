<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\DTOs\Queries\ListAvailableOffersQuery;
use Cashback\Offers\Mappers\OfferEntityMapper;
use Cashback\Offers\Queries\ListAvailableOffersHandler;
use Cashback\Offers\Services\OfferListProjector;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;
use DateTimeImmutable;

final class ListAvailableOffersHandlerTest extends TestCase
{
    public function test_it_respects_window_and_status_using_as_of(): void
    {
        $asOf = new DateTimeImmutable('2024-06-15T12:00:00Z');
        $rows = [
            $this->offerRow(1, 'active', '2024-01-01 00:00:00', '2024-12-31 23:59:59'),
            $this->offerRow(2, 'active', '2025-01-01 00:00:00', '2025-12-31 23:59:59'),
            $this->offerRow(3, 'inactive', '2024-01-01 00:00:00', '2024-12-31 23:59:59'),
        ];
        $repository = new InMemoryOfferRepository($rows);
        $handler = new ListAvailableOffersHandler(
            $repository,
            new OfferListProjector(new OfferEntityMapper),
        );

        $result = $handler->handle(new ListAvailableOffersQuery(asOf: $asOf));

        $this->assertCount(1, $result);
        $this->assertSame(1, $result[0]->id);
    }

    /**
     * @return array<string, mixed>
     */
    private function offerRow(int $id, string $status, ?string $startsAt, ?string $endsAt): array
    {
        return [
            'id' => $id,
            'merchant_id' => 1,
            'affiliate_network_id' => 1,
            'title' => 'Offer '.$id,
            'description' => null,
            'tracking_url' => 'https://track.example/'.$id,
            'cashback_type' => 'percentage',
            'cashback_value' => 1.0,
            'currency' => 'USD',
            'status' => $status,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
        ];
    }
}
