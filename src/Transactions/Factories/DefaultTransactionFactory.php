<?php

namespace Cashback\Transactions\Factories;

use Cashback\Transactions\DTOs\RecordConversionData;
use Cashback\Transactions\Entities\Transaction;

final class DefaultTransactionFactory implements TransactionFactory
{
    public function fromConversionData(RecordConversionData $data): Transaction
    {
        return new Transaction(
            id: 0,
            userId: null,
            status: $data->status,
            cashbackAmount: $data->cashbackAmount,
            confirmedAt: null,
            reversedAt: null,
            paidAt: null,
        );
    }
}
