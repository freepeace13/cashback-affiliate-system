<?php

namespace Cashback\Ledger\Mappers;

use Cashback\Ledger\DTOs\LedgerEntryData;
use Cashback\Ledger\Entities\LedgerEntry;

class LedgerEntryEntityMapper
{
    public function mapEntityToData(LedgerEntry $entry): LedgerEntryData
    {
        return new LedgerEntryData(
            id: (string) $entry->id(),
            userId: $entry->userId(),
        );
    }
}
