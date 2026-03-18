<?php

namespace Cashback\Tests\Doubles;

use Cashback\Offers\Entities\Merchant;
use Cashback\Offers\Repositories\MerchantRepository;
use Cashback\Offers\ValueObjects\MerchantID;

final class InMemoryMerchantRepository implements MerchantRepository
{
    /**
     * @var array<string, Merchant>
     */
    private array $merchants = [];

    public function create(Merchant $merchant): void
    {
        $this->merchants[$merchant->id] = $merchant;
    }

    public function find(MerchantID $id): ?Merchant
    {
        return $this->merchants[$id->value()] ?? null;
    }

    public function update(MerchantID $id, Merchant $merchant): void
    {
        $this->merchants[$id->value()] = $merchant;
    }

    public function delete(MerchantID $id): void
    {
        unset($this->merchants[$id->value()]);
    }

    public function findBySlug(string $slug): ?Merchant
    {
        return $this->merchants[$slug] ?? null;
    }

    public function listActiveMerchants(): array
    {
        return array_values($this->merchants);
    }

    public function listMerchantsWithAvailableOffers(): array
    {
        return array_values($this->merchants);
    }
}

