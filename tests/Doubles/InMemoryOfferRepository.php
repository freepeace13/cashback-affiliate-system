<?php

namespace Cashback\Tests\Doubles;

use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Repositories\OfferRepository;
use Cashback\Offers\ValueObjects\MerchantID;
use Cashback\Offers\ValueObjects\OfferID;
use Cashback\Tests\Doubles\Mappers\OfferMapper;
use Illuminate\Support\Collection;

final class InMemoryOfferRepository implements OfferRepository
{
    private Collection $offers;

    public function __construct(array $offers = [])
    {
        $this->offers = new Collection($offers);
    }

    public function listActiveOffers(): array
    {
        return $this->mapToDomain($this->offers->filter(
            fn(array $row) => $row['status'] === 'active'
        ));
    }

    public function listAvailableOffers(): array
    {
        return $this->mapToDomain($this->offers->filter(
            function (array $row) {
                return $row['starts_at'] <= new \DateTimeImmutable() && $row['ends_at'] >= new \DateTimeImmutable();
            }
        ));
    }

    public function listOffersByAffiliateNetwork(): array
    {
        return $this->mapToDomain($this->offers);
    }

    protected function mapToDomain(Collection $rows): array
    {
        return $rows->map(
            fn(array $row) => OfferMapper::toDomain($row)
        )->values()->all();
    }

    public function listMerchantOffers($merchantId): array
    {
        return $this->mapToDomain($this->offers->filter(
            fn(array $row) => $row['merchant_id'] === $merchantId
        ));
    }

    public function create(Offer $offer): Offer
    {
        $nextId = $this->offers->max('id') + 1;

        $this->offers->push($created = array_replace(
            OfferMapper::toPersistence($offer),
            [
                'id' => $nextId,
                'created_at' => new \DateTimeImmutable(),
                'updated_at' => new \DateTimeImmutable(),
            ]
        ));

        return OfferMapper::toDomain($created);
    }

    public function find($id): ?Offer
    {
        $row = $this->offers->first(
            fn(array $row) => (string) $row['id'] === (string) $id
        );

        if (! $row) {
            return null;
        }

        return OfferMapper::toDomain($row);
    }

    public function update(Offer $offer): void
    {
        $existing = $this->find($offer->id());

        if ($existing === null) {
            throw new \RuntimeException('Offer not found for update');
        }

        $this->offers = $this->offers->map(
            function (array $row) use ($offer) {
                if ($row['id'] === $offer->id()) {
                    return OfferMapper::toPersistence($offer);
                }

                return $row;
            }
        );
    }
}
