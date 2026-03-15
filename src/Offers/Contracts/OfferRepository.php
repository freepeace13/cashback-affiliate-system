<?php

namespace CashbackAffiliateSystem\Offers\Contracts;

use CashbackAffiliateSystem\Offers\Entities\Offer;

interface OfferRepository
{
    public function find(string $id): ?Offer;

    public function listByMerchantId(string $merchantId): array;

    public function listAll(): array;

    public function save(Offer $offer): void;

    public function delete(string $id): void;
}