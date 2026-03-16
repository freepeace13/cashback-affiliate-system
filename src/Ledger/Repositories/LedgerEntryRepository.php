<?php

namespace CashbackAffiliateSystem\Ledger\Repositories;

use CashbackAffiliateSystem\Ledger\Entities\LedgerEntry;
use CashbackAffiliateSystem\Ledger\ValueObjects\LedgerEntryID;

interface LedgerEntryRepository
{
    public function find(LedgerEntryID $id): ?LedgerEntry;

    public function listByUserId(string $userId): array;

    public function save(LedgerEntry $entry): void;
}