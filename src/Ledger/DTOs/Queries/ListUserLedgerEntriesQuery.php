<?php

namespace Cashback\Ledger\DTOs\Queries;

final class ListUserLedgerEntriesQuery
{
    public function __construct(
        public readonly string $userId,
    ) {}
}
