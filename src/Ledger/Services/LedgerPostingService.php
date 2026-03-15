<?php

namespace CashbackAffiliateSystem\Ledger\Services;

use CashbackAffiliateSystem\Shared\Contracts\LedgerPostingContract;
use CashbackAffiliateSystem\Ledger\Contracts\LedgerRepository;

class LedgerPostingService implements LedgerPostingContract
{
    public function __construct(
        private LedgerRepository $ledgerRepository,
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