<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\UpdateOffer;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\ValueObjects\OfferID;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;
use RuntimeException;

final class UpdateOfferTest extends TestCase
{
    public function test_it_updates_an_existing_offer(): void
    {
        $repository = new InMemoryOfferRepository();
        $id = new OfferID('offer-1');

        $existing = new Offer(
            id: $id->value(),
            name: 'Old Name',
            description: 'Old description',
            trackingUrl: 'https://example.com/old',
            cashbackType: 'percentage',
            cashbackValue: '1',
            currency: 'USD',
            status: 'inactive',
            createdAt: '2024-01-01T00:00:00Z',
            updatedAt: '2024-01-01T00:00:00Z',
        );

        $repository->create($existing);

        $action = new UpdateOffer($repository);

        $data = new OfferData(
            name: 'New Name',
            description: 'New description',
            trackingUrl: 'https://example.com/new',
            cashbackType: 'percentage',
            cashbackValue: '5',
            currency: 'USD',
            status: 'active',
            createdAt: '2024-01-01T00:00:00Z',
            updatedAt: '2024-02-01T00:00:00Z',
        );

        $returned = $action->update($id, $data);

        $this->assertSame($data->name, $returned->name);
        $this->assertSame($data->description, $returned->description);
        $this->assertSame($data->trackingUrl, $returned->trackingUrl);
        $this->assertSame($data->cashbackType, $returned->cashbackType);
        $this->assertSame($data->cashbackValue, $returned->cashbackValue);
        $this->assertSame($data->currency, $returned->currency);
        $this->assertSame($data->status, $returned->status);
        $this->assertSame($data->createdAt, $returned->createdAt);
        $this->assertSame($data->updatedAt, $returned->updatedAt);

        $stored = $repository->find($id);
        $this->assertNotNull($stored);
        $this->assertSame($id->value(), $stored->id);
        $this->assertSame($data->name, $stored->name);
    }

    public function test_it_throws_when_offer_not_found(): void
    {
        $repository = new InMemoryOfferRepository();
        $action = new UpdateOffer($repository);

        $id = new OfferID('missing-offer');
        $data = new OfferData(
            name: 'Any',
            description: 'Any',
            trackingUrl: 'https://example.com',
            cashbackType: 'percentage',
            cashbackValue: '1',
            currency: 'USD',
            status: 'active',
            createdAt: '2024-01-01T00:00:00Z',
            updatedAt: '2024-01-01T00:00:00Z',
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Offer not found for ID '.$id->value());

        $action->update($id, $data);
    }
}

