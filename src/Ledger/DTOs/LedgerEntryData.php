<?php

namespace Cashback\Ledger\DTOs;

final class LedgerEntryData
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
    ) {}
}