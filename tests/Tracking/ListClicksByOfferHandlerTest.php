<?php

namespace Cashback\Tests\Tracking;

use Cashback\Tracking\DTOs\Queries\ListClicksByOfferQuery;
use Cashback\Tracking\Entities\Click;
use Cashback\Tracking\Mappers\ClickEntityMapper;
use Cashback\Tracking\Queries\ListClicksByOfferHandler;
use Cashback\Tests\Doubles\InMemoryClickReadRepository;
use Cashback\Tests\TestCase;
use DateTimeImmutable;

final class ListClicksByOfferHandlerTest extends TestCase
{
    public function test_it_returns_only_clicks_for_the_given_offer(): void
    {
        $clickedAt = new DateTimeImmutable('2024-03-01T12:00:00Z');
        $clicks = [
            $this->click('c1', 'ref-1', offerId: 10, clickedAt: $clickedAt),
            $this->click('c2', 'ref-2', offerId: 10, clickedAt: $clickedAt),
            $this->click('c3', 'ref-3', offerId: 99, clickedAt: $clickedAt),
        ];
        $handler = new ListClicksByOfferHandler(
            new InMemoryClickReadRepository($clicks),
            new ClickEntityMapper,
        );

        $result = $handler->handle(new ListClicksByOfferQuery(offerId: 10));

        $this->assertCount(2, $result);
        $this->assertSame(['c1', 'c2'], array_map(fn ($row) => $row->id, $result));
    }

    private function click(
        string $id,
        string $clickRef,
        int $offerId,
        DateTimeImmutable $clickedAt,
    ): Click {
        return new Click(
            id: $id,
            clickRef: $clickRef,
            userId: null,
            merchantId: 1,
            offerId: $offerId,
            affiliateNetworkId: 1,
            destinationUrl: 'https://merchant.example',
            trackingUrl: 'https://network.example/out',
            clickedAt: $clickedAt,
        );
    }
}
