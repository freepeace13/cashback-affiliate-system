<?php

namespace Cashback\Ledger\Repositories;

use Cashback\Ledger\Entities\LedgerEntry;
use Cashback\Ledger\ValueObjects\LedgerEntryID;

interface LedgerEntryRepository
{
    public function find(LedgerEntryID $id): ?LedgerEntry;

    public function listByUserId(string $userId): array;

    public function save(LedgerEntry $entry): void;
}