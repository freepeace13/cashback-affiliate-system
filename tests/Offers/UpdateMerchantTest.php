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

        $existing = new Merchant(
            id: 0,
            name: 'Old Merchant',
            slug: 'old-merchant',
            status: 'active',
            websiteUrl: 'https://example.com',
            logoUrl: null,
        );

        $created = $repository->create($existing);

        $action = new UpdateMerchant($repository);

        $data = new MerchantData(
            id: $created->id(),
            name: 'New Merchant',
            slug: 'new-merchant',
            websiteUrl: 'https://example.com',
            logoUrl: 'https://example.com/logo.png',
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
        $action = new UpdateMerchant($repository);

        $data = new MerchantData(
            id: 0,
            name: 'Any',
            slug: 'any',
            websiteUrl: 'https://example.com',
            logoUrl: 'https://example.com/logo.png',
            status: 'active',
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Merchant not found for update');

        $action->update($data);
    }
}
