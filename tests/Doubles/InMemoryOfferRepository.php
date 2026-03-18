<?php

namespace Cashback\Tests\Doubles;

use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Repositories\OfferRepository;
use Cashback\Offers\ValueObjects\MerchantID;
use Cashback\Offers\ValueObjects\OfferID;

final class InMemoryOfferRepository implements OfferRepository
{
    /**
     * @var array<string, Offer>
     */
    private array $offers = [];

    public function create(Offer $offer): void
    {
        if ($offer->id === '') {
            $offer->id = (string) (count($this->offers) + 1);
        }

        $this->offers[$offer->id] = $offer;
    }

    public function find(OfferID $id): ?Offer
    {
        return $this->offers[$id->value()] ?? null;
    }

    public function update(OfferID $id, Offer $offer): void
    {
        $this->offers[$id->value()] = $offer;
    }

    public function delete(OfferID $id): void
    {
        unset($this->offers[$id->value()]);
    }

    public function listActiveOffers(): array
    {
        return array_values($this->offers);
    }

    public function listAvailableOffers(): array
    {
        return array_values($this->offers);
    }

    public function listOffersByAffiliateNetwork()
    {
        return array_values($this->offers);
    }

    public function listMerchantOffers(MerchantID $merchantId): array
    {
        return array_values($this->offers);
    }
}

