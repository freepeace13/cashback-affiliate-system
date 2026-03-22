<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\DTOs\Queries\ListOffersByNetworkQuery;
use Cashback\Offers\Mappers\OfferEntityMapper;
use Cashback\Offers\Queries\ListOffersByNetworkHandler;
use Cashback\Offers\Services\OfferListProjector;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;

final class ListOffersByNetworkHandlerTest extends TestCase
{
    public function test_it_returns_only_offers_for_network(): void
    {
        $rows = [
            $this->offerRow(1, 10),
            $this->offerRow(2, 20),
            $this->offerRow(3, 10),
        ];
        $repository = new InMemoryOfferRepository($rows);
        $handler = new ListOffersByNetworkHandler(
            $repository,
            new OfferListProjector(new OfferEntityMapper),
        );

        $result = $handler->handle(new ListOffersByNetworkQuery(networkId: 10));

        $this->assertCount(2, $result);
        $this->assertSame([1, 3], array_map(fn ($d) => $d->id, $result));
    }

    /**
     * @return array<string, mixed>
     */
    private function offerRow(int $id, int $networkId): array
    {
        return [
            'id' => $id,
            'merchant_id' => 1,
            'affiliate_network_id' => $networkId,
            'title' => 'Offer '.$id,
            'description' => null,
            'tracking_url' => 'https://track.example/'.$id,
            'cashback_type' => 'percentage',
            'cashback_value' => 1.0,
            'currency' => 'USD',
            'status' => 'active',
            'starts_at' => null,
            'ends_at' => null,
        ];
    }
}
