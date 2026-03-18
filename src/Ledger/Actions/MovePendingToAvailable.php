<?php

namespace Cashback\Ledger\Actions;

use Cashback\Ledger\Contracts\MovesPendingToAvailableAction;
use Cashback\Ledger\Repositories\LedgerEntryRepository;

class MovePendingToAvailable implements MovesPendingToAvailableAction
{
    public function __construct(
        private LedgerEntryRepository $ledgerRepository,
    ) {}

    public function move(string $userId): void
    {
        //
    }
}
