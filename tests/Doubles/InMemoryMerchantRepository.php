<?php

namespace Cashback\Tests\Doubles;

use Cashback\Offers\Entities\Merchant;
use Cashback\Offers\Repositories\MerchantRepository;
use Cashback\Tests\Doubles\Mappers\MerchantMapper;
use Illuminate\Support\Collection;

class InMemoryMerchantRepository implements MerchantRepository
{
    /** @var Collection<array<string, array>> */
    protected Collection $merchants;

    public function __construct(array $merchants = [])
    {
        $this->merchants = new Collection($merchants);
    }

    public function listActiveMerchants(): array
    {
        return $this->mapToDomain($this->merchants->filter(
            fn(array $row) => $row['status'] === 'active'
        ));
    }

    public function listMerchantsWithAvailableOffers(): array
    {
        return $this->mapToDomain($this->merchants->filter(
            fn(array $row) => $row['status'] === 'active' && count($row['offers']) > 0
        ));
    }

    protected function mapToDomain(Collection $rows): array
    {
        return $rows->map(
            fn(array $row) => MerchantMapper::toDomain($row)
        )->values()->all();
    }

    public function findBySlug($slug): ?Merchant
    {
        $row = $this->merchants->first(fn(array $row) => $row['slug'] === (string) $slug);

        if (! $row) {
            return null;
        }

        return MerchantMapper::toDomain($row);
    }

    public function create(Merchant $merchant): Merchant
    {
        $nextId = $this->merchants->max('id') + 1;

        $this->merchants->push($created = array_replace(
            MerchantMapper::toPersistence($merchant),
            [
                'id' => $nextId,
                'created_at' => new \DateTimeImmutable(),
                'updated_at' => new \DateTimeImmutable(),
            ]
        ));

        return MerchantMapper::toDomain($created);
    }

    public function find($id): ?Merchant
    {
        $existing = $this->merchants->first(
            fn(array $row) => (string) $row['id'] === (string) $id
        );

        if (! $existing) {
            return null;
        }

        return MerchantMapper::toDomain($existing);
    }

    public function update(Merchant $merchant): void
    {
        $existing = $this->find($merchant->id());

        if ($existing === null) {
            throw new \RuntimeException('Merchant not found for update');
        }

        $this->merchants = $this->merchants->map(
            function (array $row) use ($merchant) {
                if ($row['id'] === $merchant->id()) {
                    return MerchantMapper::toPersistence($merchant);
                }

                return $row;
            }
        );
    }
}
