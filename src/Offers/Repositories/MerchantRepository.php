<?php

namespace Cashback\Offers\Repositories;

use Cashback\Offers\Entities\Merchant;

interface MerchantRepository
{
    public function findBySlug($slug): ?Merchant;

    public function listActiveMerchants(): array;

    public function listMerchantsWithAvailableOffers(): array;

    public function create(Merchant $merchant): Merchant;

    public function find($id): ?Merchant;

    public function update(Merchant $merchant): void;
}
