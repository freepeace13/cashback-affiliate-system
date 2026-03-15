<?php

namespace CashbackAffiliateSystem\Offers\Contracts;

use CashbackAffiliateSystem\Offers\Entities\Merchant;

interface MerchantRepository
{
    public function find(string $id): ?Merchant;

    public function listAll(): array;

    public function save(Merchant $merchant): void;
}