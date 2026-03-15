<?php

namespace CashbackAffiliateSystem\Tracking\Contracts;

use CashbackAffiliateSystem\Tracking\Entities\Click;

interface ClickRepository
{
    public function find(string $id): ?Click;

    public function save(Click $click): void;
}