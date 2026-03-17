<?php

namespace Cashback\Offers\Repositories;

use Cashback\Offers\Entities\Offer;

interface OfferRepository
{
    public function create(Offer $offer): void;
    
    public function find(OfferID $id): ?Offer;

    public function update(OfferID $id, Offer $offer): void;

    public function delete(OfferID $id): void;

    public function listActiveOffers(): array;

    public function listAvailableOffers(): array;

    public function listOffersByAffiliateNetwork();

    public function listMerchantOffers(MerchantID $merchantId): array;
}

