<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\UpdateOfferAction;
use Cashback\Offers\DTOs\Actions\UpdateOfferData;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Enums\OfferStatus;
use Cashback\Offers\Exceptions\OfferNotFound;
use Cashback\Offers\Mappers\OfferEntityMapper;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;

final class UpdateOfferTest extends TestCase
{
    public function test_it_updates_an_existing_offer(): void
    {
        $repository = new InMemoryOfferRepository();

        $existing = new Offer(
            id: 1,
            merchantId: 1,
            affiliateNetworkId: 1,
            title: 'Old Name',
            description: 'Old description',
            trackingUrl: 'https://example.com/old',
            cashbackType: 'percentage',
            cashbackValue: 1.0,
            currency: 'USD',
            status: OfferStatus::INACTIVE,
            startsAt: null,
            endsAt: null,
        );

        $created = $repository->create($existing);

        $action = new UpdateOfferAction($repository, $repository, new OfferEntityMapper());

        $data = new UpdateOfferData(
            id: $created->id(),
            merchantId: 1,
            affiliateNetworkId: 1,
            title: 'New Name',
            description: 'New description',
            trackingUrl: 'https://example.com/new',
            cashbackType: 'percentage',
            cashbackValue: '5',
            currency: 'USD',
            status: 'active',
        );

        $returned = $action->update($data);

        $this->assertInstanceOf(OfferData::class, $returned);
        $this->assertSame($data->title, $returned->title);
        $this->assertSame($data->description, $returned->description);
        $this->assertSame($data->trackingUrl, $returned->trackingUrl);
        $this->assertSame($data->cashbackType, $returned->cashbackType);
        $this->assertSame($data->cashbackValue, $returned->cashbackValue);
        $this->assertSame($data->currency, $returned->currency);
        $this->assertSame($data->status, $returned->status);

        $stored = $repository->find($created->id());
        $this->assertNotNull($stored);
        $this->assertSame((int) $created->id(), $stored->id());
        $this->assertSame($data->title, $stored->title());
    }

    public function test_partial_update_preserves_schedule_when_dates_omitted(): void
    {
        $repository = new InMemoryOfferRepository();

        $existing = new Offer(
            id: 1,
            merchantId: 1,
            affiliateNetworkId: 1,
            title: 'Old Name',
            description: 'Old description',
            trackingUrl: 'https://example.com/old',
            cashbackType: 'percentage',
            cashbackValue: 1.0,
            currency: 'USD',
            status: OfferStatus::ACTIVE,
            startsAt: new \DateTimeImmutable('2024-03-01T00:00:00Z'),
            endsAt: new \DateTimeImmutable('2024-09-01T00:00:00Z'),
        );

        $created = $repository->create($existing);

        $action = new UpdateOfferAction($repository, $repository, new OfferEntityMapper());

        $data = new UpdateOfferData(
            id: $created->id(),
            merchantId: 1,
            affiliateNetworkId: 1,
            title: 'New Name',
            description: 'New description',
            trackingUrl: 'https://example.com/new',
            cashbackType: 'percentage',
            cashbackValue: '5',
            currency: 'USD',
            status: 'active',
            startsAt: null,
            endsAt: null,
        );

        $action->update($data);

        $stored = $repository->find($created->id());
        $this->assertNotNull($stored);
        $this->assertEquals(new \DateTimeImmutable('2024-03-01T00:00:00Z'), $stored->startsAt());
        $this->assertEquals(new \DateTimeImmutable('2024-09-01T00:00:00Z'), $stored->endsAt());
    }

    public function test_it_throws_when_offer_not_found(): void
    {
        $repository = new InMemoryOfferRepository();
        $action = new UpdateOfferAction($repository, $repository, new OfferEntityMapper());

        $data = new UpdateOfferData(
            id: 999,
            merchantId: 1,
            affiliateNetworkId: 1,
            title: 'Any',
            description: 'Any',
            trackingUrl: 'https://example.com',
            cashbackType: 'percentage',
            cashbackValue: '1',
            currency: 'USD',
            status: 'active',
        );

        $this->expectException(OfferNotFound::class);
        $this->expectExceptionMessage('Offer not found for update');

        $action->update($data);
    }
}
