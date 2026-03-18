<?php

namespace Cashback\Ledger\Contracts;

interface ReservesPayoutFundsAction
{
    public function reserve(
        string $userId,
        string $transactionId,
        int $amountInMinor,
        string $currency,
    ): void;
}
