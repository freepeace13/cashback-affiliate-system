<?php

namespace Cashback\Offers\Repositories;

use Cashback\Offers\Entities\Merchant;
use Cashback\Offers\ValueObjects\MerchantID;

interface MerchantRepository
{
    public function create(Merchant $merchant): void;
    
    public function find(MerchantID $id): ?Merchant;
    
    public function update(MerchantID $id, Merchant $merchant): void;

    public function delete(MerchantID $id): void;

    public function findBySlug(string $slug): ?Merchant;

    public function listActiveMerchants(): array;

    public function listMerchantsWithAvailableOffers(): array;
}

