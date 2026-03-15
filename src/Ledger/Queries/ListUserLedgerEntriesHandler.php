<?php

namespace CashbackAffiliateSystem\Ledger\Queries;

use CashbackAffiliateSystem\Ledger\Contracts\LedgerRepository;
use CashbackAffiliateSystem\Ledger\DTOs\LedgerEntryData;
use CashbackAffiliateSystem\Ledger\Entities\LedgerEntry;
use CashbackAffiliateSystem\Ledger\Queries\ListUserLedgerEntriesQuery;

class ListUserLedgerEntriesHandler
{
    public function __construct(
        private LedgerRepository $ledgerRepository,
    ) {}

    public function handle(ListUserLedgerEntriesQuery $query): array
    {
        $entries = $this->ledgerRepository->listByUserId($query->userId);

        return array_map(fn (LedgerEntry $entry): LedgerEntryData => new LedgerEntryData(
            id: $entry->id()->value(),
            userId: $entry->userId(),
        ), $entries);
    }
}