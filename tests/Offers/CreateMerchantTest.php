<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\CreateMerchantAction;
use Cashback\Offers\DTOs\Actions\CreateMerchantData;
use Cashback\Offers\Mappers\MerchantEntityMapper;
use Cashback\Tests\Doubles\InMemoryMerchantRepository;
use Cashback\Tests\TestCase;
use Illuminate\Support\Str;

final class CreateMerchantTest extends TestCase
{
    public function test_it_creates_a_merchant_from_dto(): void
    {
        $repository = new InMemoryMerchantRepository();
        $action = new CreateMerchantAction($repository, new MerchantEntityMapper());

        $name = $this->faker->company();
        $data = new CreateMerchantData(
            name: $name,
            website_url: $this->faker->url(),
            logo_url: $this->faker->imageUrl(),
            status: 'active',
        );

        $returned = $action->create($data);

        $expectedSlug = Str::slug($name);
        $this->assertSame($expectedSlug, $returned->slug);
        $this->assertSame($name, $returned->name);

        $created = $repository->findBySlug($expectedSlug);

        $this->assertNotNull($created);
        $this->assertSame($expectedSlug, $created->slug());
        $this->assertSame($name, $created->name());
    }
}
