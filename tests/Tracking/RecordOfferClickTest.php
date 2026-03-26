<?php

namespace Cashback\Tests\Tracking;

use Cashback\Contracts\EventBus;
use Cashback\Tracking\Actions\RecordOfferClick;
use Cashback\Tracking\DTOs\Actions\RecordOfferClickData;
use Cashback\Tracking\Entities\Click;
use Cashback\Tracking\Exceptions\OfferNotFoundForClick;
use Cashback\Tracking\Mappers\ClickEntityMapper;
use Cashback\Tracking\Repositories\ClickWriteRepository;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;

final class RecordOfferClickTest extends TestCase
{
    public function test_it_derives_offer_linked_fields_from_offer_id(): void
    {
        $offers = new InMemoryOfferRepository([[
            'id' => 99,
            'merchant_id' => 13,
            'affiliate_network_id' => 7,
            'title' => 'Test Offer',
            'description' => null,
            'tracking_url' => 'https://network.test/track?offer=99',
            'cashback_type' => 'percentage',
            'cashback_value' => 5.0,
            'currency' => 'USD',
            'status' => 'active',
            'starts_at' => null,
            'ends_at' => null,
        ]]);

        $writeRepo = new class implements ClickWriteRepository {
            public ?Click $savedClick = null;

            public function find(string $id): ?Click
            {
                return null;
            }

            public function save(Click $click): Click
            {
                $this->savedClick = $click;

                return $click->withId('click-1');
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
            public function publish($event): void {}
            public function subscribe(string $event, callable $listener): void {}
        };

        $action = new RecordOfferClick(
            clicksWriteRepository: $writeRepo,
            clickEntityMapper: new ClickEntityMapper(),
            eventBus: $eventBus,
            offerQueries: $offers,
        );

        $action->record(new RecordOfferClickData(
            userId: 'user-10',
            offerId: '99',
            destinationUrl: 'https://merchant.test/product',
        ));

        $this->assertNotNull($writeRepo->savedClick);
        $this->assertSame(13, $writeRepo->savedClick->merchantId());
        $this->assertSame(7, $writeRepo->savedClick->affiliateNetworkId());
        $this->assertSame('https://network.test/track?offer=99', $writeRepo->savedClick->trackingUrl());
    }

    public function test_it_throws_when_offer_does_not_exist(): void
    {
        $offers = new InMemoryOfferRepository([]);
        $writeRepo = new class implements ClickWriteRepository {
            public function find(string $id): ?Click { return null; }
            public function save(Click $click): Click { return $click; }
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
            public function publish($event): void {}
            public function subscribe(string $event, callable $listener): void {}
        };

        $action = new RecordOfferClick(
            clicksWriteRepository: $writeRepo,
            clickEntityMapper: new ClickEntityMapper(),
            eventBus: $eventBus,
            offerQueries: $offers,
        );

        $this->expectException(OfferNotFoundForClick::class);
        $action->record(new RecordOfferClickData(
            userId: 'user-10',
            offerId: '999',
            destinationUrl: 'https://merchant.test/product',
        ));
    }
}
