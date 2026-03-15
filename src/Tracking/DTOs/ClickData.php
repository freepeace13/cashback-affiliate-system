<?php

namespace CashbackAffiliateSystem\Tracking\DTOs;

final class ClickData
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
    ) {}
}