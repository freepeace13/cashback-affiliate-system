<?php

namespace Cashback\Ledger\Actions;

use Cashback\Ledger\Contracts\PostsPendingCashbackAction;
use Cashback\Ledger\Repositories\LedgerEntryRepository;

class PostPendingCashback implements PostsPendingCashbackAction
{
    public function __construct(
        private LedgerEntryRepository $ledgerRepository,
    ) {}

    public function post(
        string $userId,
        string $transactionId,
        int $amountInMinor,
        string $currency,
    ): void {
        //
    }
}
