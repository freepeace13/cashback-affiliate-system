<?php

namespace Cashback\Ledger\Actions;

use Cashback\Ledger\Contracts\ReservesPayoutFundsAction;
use Cashback\Ledger\Repositories\LedgerEntryRepository;

class ReservePayoutFunds implements ReservesPayoutFundsAction
{
    public function __construct(
        private LedgerEntryRepository $ledgerRepository,
    ) {}

    public function reserve(
        string $userId,
        string $transactionId,
        int $amountInMinor,
        string $currency,
    ): void {
        //
    }
}
