<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\AssignOfferMerchantAction;
use Cashback\Offers\Exceptions\MerchantNotFound;
use Cashback\Offers\Exceptions\OfferNotFound;
use Cashback\Tests\Doubles\InMemoryMerchantRepository;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;

final class AssignOfferMerchantTest extends TestCase
{
    public function test_it_assigns_offer_to_merchant(): void
    {
        $offerRepository = new InMemoryOfferRepository([$this->sampleOfferRow(1, 1, 1)]);
        $merchantRepository = new InMemoryMerchantRepository([
            $this->sampleMerchantRow(1, 'first'),
            $this->sampleMerchantRow(2, 'second'),
        ]);

        $action = new AssignOfferMerchantAction($offerRepository, $offerRepository, $merchantRepository);
        $action->assign(1, 2);

        $updated = $offerRepository->find(1);
        $this->assertNotNull($updated);
        $this->assertSame(2, $updated->merchantId());
    }

    public function test_it_throws_when_offer_missing(): void
    {
        $offerRepository = new InMemoryOfferRepository([]);
        $merchantRepository = new InMemoryMerchantRepository([$this->sampleMerchantRow(1, 'm')]);

        $action = new AssignOfferMerchantAction($offerRepository, $offerRepository, $merchantRepository);

        $this->expectException(OfferNotFound::class);
        $action->assign(99, 1);
    }

    public function test_it_throws_when_merchant_missing(): void
    {
        $offerRepository = new InMemoryOfferRepository([$this->sampleOfferRow(1, 1, 1)]);
        $merchantRepository = new InMemoryMerchantRepository([]);

        $action = new AssignOfferMerchantAction($offerRepository, $offerRepository, $merchantRepository);

        $this->expectException(MerchantNotFound::class);
        $action->assign(1, 99);
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

    /**
     * @return array<string, mixed>
     */
    private function sampleMerchantRow(int $id, string $slugSuffix): array
    {
        return [
            'id' => $id,
            'name' => 'Merchant '.$id,
            'slug' => 'merchant-'.$slugSuffix,
            'status' => 'active',
            'website_url' => 'https://example.com',
            'logo_url' => '',
        ];
    }
}
