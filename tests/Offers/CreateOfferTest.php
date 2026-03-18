<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\CreateOffer;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;

final class CreateOfferTest extends TestCase
{
    public function test_it_creates_an_offer_from_dto(): void
    {
        $repository = new InMemoryOfferRepository();
        $action = new CreateOffer($repository);

        $data = new OfferData(
            id: 0,
            title: $this->faker->catchPhrase(),
            description: $this->faker->sentence(),
            trackingUrl: $this->faker->url(),
            cashbackType: 'percentage',
            cashbackValue: '5',
            currency: 'USD',
            status: 'active',
        );

        $returned = $action->create($data);

        $this->assertSame($data->title, $returned->title);

        $offers = $repository->listActiveOffers();
        $this->assertCount(1, $offers);

        $created = $offers[0];
        $this->assertSame($data->title, $created->title());
        $this->assertSame($data->description, $created->description() ?? '');
        $this->assertSame($data->trackingUrl, $created->trackingUrl());
        $this->assertSame($data->cashbackType, $created->cashbackType());
        $this->assertSame($data->cashbackValue, (string) $created->cashbackValue());
        $this->assertSame($data->currency, $created->currency());
        $this->assertSame($data->status, $created->status()->value);
    }
}
