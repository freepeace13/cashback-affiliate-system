<?php

namespace CashbackAffiliateSystem\Tracking\Entities;

class Click
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
    ) {}
}