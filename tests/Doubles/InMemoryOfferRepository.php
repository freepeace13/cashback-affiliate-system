<?php

namespace Cashback\Tests\Doubles;

use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Repositories\OfferRepository;
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

    public function listAvailableOffers(\DateTimeImmutable $asOf): array
    {
        $active = $this->listActiveOffers();

        return array_values(array_filter(
            $active,
            fn (Offer $offer) => $offer->isAvailable($asOf)
        ));
    }

    public function listOffersByAffiliateNetwork(int $affiliateNetworkId): array
    {
        return $this->mapToDomain($this->offers->filter(
            fn (array $row) => (int) $row['affiliate_network_id'] === $affiliateNetworkId
        ));
    }

    protected function mapToDomain(Collection $rows): array
    {
        return $rows->map(
            fn(array $row) => OfferMapper::toDomain($row)
        )->values()->all();
    }

    public function listMerchantOffers(int $merchantId): array
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

    public function find(int|string $id): ?Offer
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
