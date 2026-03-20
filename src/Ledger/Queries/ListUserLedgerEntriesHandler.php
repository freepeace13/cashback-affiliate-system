<?php

namespace Cashback\Ledger\Queries;

use Cashback\Ledger\Contracts\Queries\ListUserLedgerEntriesQueryHandler;
use Cashback\Ledger\DTOs\LedgerEntryData;
use Cashback\Ledger\DTOs\Queries\ListUserLedgerEntriesQuery;
use Cashback\Ledger\Entities\LedgerEntry;
use Cashback\Ledger\Mappers\LedgerEntryEntityMapper;
use Cashback\Ledger\Repositories\LedgerEntryRepository;

class ListUserLedgerEntriesHandler implements ListUserLedgerEntriesQueryHandler
{
    public function __construct(
        private LedgerEntryRepository $ledgerRepository,
        private LedgerEntryEntityMapper $ledgerEntryEntityMapper,
    ) {}

    public function handle(ListUserLedgerEntriesQuery $query): array
    {
        $entries = $this->ledgerRepository->listByUserId($query->userId);

        return array_map(
            fn (LedgerEntry $entry): LedgerEntryData => $this->ledgerEntryEntityMapper->mapEntityToData($entry),
            $entries
        );
    }
}
