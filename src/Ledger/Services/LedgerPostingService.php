<?php

namespace Cashback\Ledger\Services;

use Cashback\Shared\Repositories\LedgerPostingContract;
use Cashback\Ledger\Repositories\LedgerEntryRepository;

class LedgerPostingService implements LedgerPostingContract
{
    public function __construct(
        private LedgerEntryRepository $ledgerRepository,
    ) {}

    public function reverseConfirmedCashback(
        string $userId,
        string $transactionId,
        int $amountInMinor,
        string $currency,
    ): void
    {
        //
    }

    public function reversePendingCashback(
        string $userId,
        string $transactionId,
        int $amountInMinor,
        string $currency,
    ): void
    {
        //
    }
}