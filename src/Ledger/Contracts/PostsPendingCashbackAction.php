<?php

namespace Cashback\Ledger\Contracts;

interface PostsPendingCashbackAction
{
    public function post(
        string $userId,
        string $transactionId,
        int $amountInMinor,
        string $currency,
    ): void;
}
