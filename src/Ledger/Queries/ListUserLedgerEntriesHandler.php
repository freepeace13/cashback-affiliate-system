<?php

namespace Cashback\Ledger\Queries;

use Cashback\Ledger\Repositories\LedgerEntryRepository;
use Cashback\Ledger\DTOs\LedgerEntryData;
use Cashback\Ledger\Entities\LedgerEntry;
use Cashback\Ledger\Queries\ListUserLedgerEntriesQuery;

class ListUserLedgerEntriesHandler
{
    public function __construct(
        private LedgerEntryRepository $ledgerRepository,
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