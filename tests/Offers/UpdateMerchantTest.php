<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\UpdateMerchant;
use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\Entities\Merchant;
use Cashback\Offers\ValueObjects\MerchantID;
use Cashback\Tests\Doubles\InMemoryMerchantRepository;
use Cashback\Tests\TestCase;
use RuntimeException;

final class UpdateMerchantTest extends TestCase
{
    public function test_it_updates_an_existing_merchant(): void
    {
        $repository = new InMemoryMerchantRepository();
        $id = new MerchantID('merchant-1');

        $existing = new Merchant(
            id: $id->value(),
            name: 'Old Merchant',
        );

        $repository->create($existing);

        $action = new UpdateMerchant($repository);

        $data = new MerchantData(
            name: 'New Merchant',
            slug: 'new-merchant',
            websiteUrl: 'https://example.com',
            logoUrl: 'https://example.com/logo.png',
            status: 'active',
            createdAt: '2024-01-01T00:00:00Z',
            updatedAt: '2024-02-01T00:00:00Z',
        );

        $returned = $action->update($id, $data);

        $this->assertSame($data, $returned);

        $stored = $repository->find($id);
        $this->assertNotNull($stored);
        $this->assertSame($id->value(), $stored->id);
        $this->assertSame($data->name, $stored->name);
    }

    public function test_it_throws_when_merchant_not_found(): void
    {
        $repository = new InMemoryMerchantRepository();
        $action = new UpdateMerchant($repository);

        $id = new MerchantID('missing-merchant');

        $data = new MerchantData(
            name: 'Any',
            slug: 'any',
            websiteUrl: 'https://example.com',
            logoUrl: 'https://example.com/logo.png',
            status: 'active',
            createdAt: '2024-01-01T00:00:00Z',
            updatedAt: '2024-01-01T00:00:00Z',
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Merchant not found for ID '.$id->value());

        $action->update($id, $data);
    }
}

