<?php

namespace Cashback\Offers\Repositories;

use Cashback\Offers\Entities\Offer;

interface OfferRepository
{
    public function listActiveOffers(): array;

    public function listAvailableOffers(): array;

    public function listOffersByAffiliateNetwork();

    public function listMerchantOffers($merchantId): array;

    public function create(Offer $offer): Offer;

    public function find($id): ?Offer;

    public function update(Offer $offer): void;
}
