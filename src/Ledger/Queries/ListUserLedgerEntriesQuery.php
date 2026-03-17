<?php

namespace Cashback\Ledger\Queries;

final class ListUserLedgerEntriesQuery
{
    public function __construct(
        public readonly string $userId
    ) {}
}