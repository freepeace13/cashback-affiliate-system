<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\CreateMerchant;
use Cashback\Offers\DTOs\MerchantData;
use Cashback\Tests\Doubles\InMemoryMerchantRepository;
use Cashback\Tests\TestCase;

final class CreateMerchantTest extends TestCase
{
    public function test_it_creates_a_merchant_from_dto(): void
    {
        $repository = new InMemoryMerchantRepository();
        $action = new CreateMerchant($repository);

        $data = new MerchantData(
            id: 0,
            name: $this->faker->company(),
            slug: $this->faker->slug(),
            websiteUrl: $this->faker->url(),
            logoUrl: $this->faker->imageUrl(),
            status: 'active'
        );

        $returned = $action->create($data);

        $this->assertSame(get_class($data), get_class($returned));

        $created = $repository->findBySlug($data->slug);

        $this->assertNotNull($created);
        $this->assertSame($data->slug, $created->slug());
        $this->assertSame($data->name, $created->name());
    }
}
