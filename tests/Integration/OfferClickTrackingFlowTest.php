<?php

namespace Cashback\Tests\Integration;

use Cashback\Contracts\EventBus;
use Cashback\Offers\Actions\GenerateOfferClickUrlAction;
use Cashback\Offers\DTOs\Actions\GenerateOfferClickUrlData;
use Cashback\Offers\Support\OfferClickTrackingParams;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;
use Cashback\Tracking\Actions\RecordOfferClick;
use Cashback\Tracking\DTOs\Actions\RecordOfferClickData;
use Cashback\Tracking\Entities\Click;
use Cashback\Tracking\Mappers\ClickEntityMapper;
use Cashback\Tracking\Repositories\ClickWriteRepository;

final class OfferClickTrackingFlowTest extends TestCase
{
    public function test_offer_click_url_generation_and_click_recording_flow(): void
    {
        $offers = new InMemoryOfferRepository([[
            'id' => 17,
            'merchant_id' => 13,
            'affiliate_network_id' => 7,
            'title' => 'Offer 17',
            'description' => null,
            'tracking_url' => 'https://network.test/track?offer=17',
            'cashback_type' => 'percentage',
            'cashback_value' => 5.0,
            'currency' => 'USD',
            'status' => 'active',
            'starts_at' => null,
            'ends_at' => null,
        ]]);

        $clickWriteRepo = new class implements ClickWriteRepository {
            public ?Click $savedClick = null;

            public function find(string $id): ?Click
            {
                return null;
            }

            public function save(Click $click): Click
            {
                $this->savedClick = $click;

                return $click->withId('click-100');
            }

            public function attachUser(string $clickRef, string $userId): void {}

            public function registerExternalRef(string $clickRef, string $externalClickRef): void {}

            public function updateMetadata(string $clickRef, array $metadata): void {}

            public function updateTrackingInfo(
                string $clickRef,
                ?string $deviceType,
                ?string $userAgent,
                ?string $ipAddress,
            ): void {}
        };

        $eventBus = new class implements EventBus {
            public array $published = [];

            public function publish($event): void
            {
                $this->published[] = $event;
            }

            public function subscribe(string $event, callable $callback): void {}
        };

        $generateUrl = new GenerateOfferClickUrlAction();
        $clickUrl = $generateUrl->generate(new GenerateOfferClickUrlData(
            baseUrl: 'https://cashback.test',
            path: '/click/redirect',
            userId: 'user-42',
            offerId: '17',
            destinationUrl: 'https://merchant.test/product/123',
        ));

        $params = OfferClickTrackingParams::fromUrl($clickUrl);

        $recordClick = new RecordOfferClick(
            clicksWriteRepository: $clickWriteRepo,
            clickEntityMapper: new ClickEntityMapper(),
            eventBus: $eventBus,
            offerQueries: $offers,
        );

        $result = $recordClick->record(new RecordOfferClickData(
            userId: $params['userId'],
            offerId: $params['offerId'],
            destinationUrl: $params['destinationUrl'],
        ));

        $this->assertSame('click-100', $result->id);
        $this->assertNotNull($clickWriteRepo->savedClick);
        $this->assertSame('user-42', $clickWriteRepo->savedClick->userId());
        $this->assertSame(13, $clickWriteRepo->savedClick->merchantId());
        $this->assertSame(17, $clickWriteRepo->savedClick->offerId());
        $this->assertSame(7, $clickWriteRepo->savedClick->affiliateNetworkId());
        $this->assertSame('https://merchant.test/product/123', $clickWriteRepo->savedClick->destinationUrl());
        $this->assertSame('https://network.test/track?offer=17', $clickWriteRepo->savedClick->trackingUrl());
        $this->assertCount(1, $eventBus->published);
    }
}
