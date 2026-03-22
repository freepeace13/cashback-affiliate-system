<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\AssignOfferNetworkAction;
use Cashback\Offers\Exceptions\OfferNotFound;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;

final class AssignOfferNetworkTest extends TestCase
{
    public function test_it_assigns_offer_to_network(): void
    {
        $repository = new InMemoryOfferRepository([$this->sampleOfferRow(1, 1, 1)]);
        $action = new AssignOfferNetworkAction($repository, $repository);

        $action->assign(1, 42);

        $updated = $repository->find(1);
        $this->assertNotNull($updated);
        $this->assertSame(42, $updated->affiliateNetworkId());
    }

    public function test_it_throws_when_offer_missing(): void
    {
        $repository = new InMemoryOfferRepository([]);
        $action = new AssignOfferNetworkAction($repository, $repository);

        $this->expectException(OfferNotFound::class);
        $action->assign(99, 1);
    }

    /**
     * @return array<string, mixed>
     */
    private function sampleOfferRow(int $id, int $merchantId, int $networkId): array
    {
        return [
            'id' => $id,
            'merchant_id' => $merchantId,
            'affiliate_network_id' => $networkId,
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
