<?php

namespace CashbackAffiliateSystem\Shared\Contracts;

interface LedgerPostingContract
{
    public function reverseConfirmedCashback(
        string $userId,
        string $transactionId,
        int $amountInMinor,
        string $currency,
    ): void;

    public function reversePendingCashback(
        string $userId,
        string $transactionId,
        int $amountInMinor,
        string $currency,
    ): void;
}