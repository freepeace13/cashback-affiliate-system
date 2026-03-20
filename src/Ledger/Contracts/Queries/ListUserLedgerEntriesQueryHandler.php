<?php

namespace Cashback\Ledger\Contracts\Queries;

use Cashback\Ledger\DTOs\LedgerEntryData;
use Cashback\Ledger\DTOs\Queries\ListUserLedgerEntriesQuery;

interface ListUserLedgerEntriesQueryHandler
{
    /**
     * @return LedgerEntryData[]
     */
    public function handle(ListUserLedgerEntriesQuery $query): array;
}
