<?php

namespace Cashback\Transactions\Mappers;

use Cashback\Transactions\DTOs\TransactionData;
use Cashback\Transactions\Entities\Transaction;

class TransactionEntityMapper
{
    public function mapEntityToData(Transaction $transaction): TransactionData
    {
        return new TransactionData(
            id: (string) $transaction->id(),
            status: $transaction->status()->value,
            orderAmountInMinor: 0,
            cashbackAmountInMinor: $transaction->cashbackAmount()->value(),
            currency: $transaction->currency(),
            trackedAt: null,
            confirmedAt: $transaction->confirmedAt()?->format(\DATE_ATOM),
        );
    }
}
