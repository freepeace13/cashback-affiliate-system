<?php

final class LedgerPostingService implements LedgerPostingContract
{
    public function reverseConfirmedCashback(
        string $userId,
        string $transactionId,
        int $amountInMinor,
        string $currency,
    ): void
    {
        //
    }
}