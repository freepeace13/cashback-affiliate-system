<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\UpdateMerchantAction;
use Cashback\Offers\DTOs\Actions\UpdateMerchantData;
use Cashback\Offers\Entities\Merchant;
use Cashback\Offers\Mappers\MerchantEntityMapper;
use Cashback\Tests\Doubles\InMemoryMerchantRepository;
use Cashback\Tests\TestCase;
use RuntimeException;

final class UpdateMerchantTest extends TestCase
{
    public function test_it_updates_an_existing_merchant(): void
    {
        $repository = new InMemoryMerchantRepository();

        $existing = new Merchant(
            id: 0,
            name: 'Old Merchant',
            slug: 'old-merchant',
            status: 'active',
            websiteUrl: 'https://example.com',
            logoUrl: '',
        );

        $created = $repository->create($existing);

        $action = new UpdateMerchantAction($repository, new MerchantEntityMapper());

        $data = new UpdateMerchantData(
            id: $created->id(),
            name: 'New Merchant',
            slug: 'new-merchant',
            website_url: 'https://example.com',
            logo_url: 'https://example.com/logo.png',
            status: 'active',
        );

        $returned = $action->update($data);

        $this->assertSame($data->name, $returned->name);

        $stored = $repository->find($created->id());
        $this->assertNotNull($stored);
        $this->assertSame((int) $created->id(), $stored->id());
        $this->assertSame($data->name, $stored->name());
    }

    public function test_it_throws_when_merchant_not_found(): void
    {
        $repository = new InMemoryMerchantRepository();
        $action = new UpdateMerchantAction($repository, new MerchantEntityMapper());

        $data = new UpdateMerchantData(
            id: 999,
            name: 'Any',
            slug: 'any',
            website_url: 'https://example.com',
            logo_url: 'https://example.com/logo.png',
            status: 'active',
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Merchant not found for update');

        $action->update($data);
    }
}
