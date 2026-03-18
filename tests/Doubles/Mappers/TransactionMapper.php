<?php

namespace Cashback\Tests\Doubles\Mappers;

use Cashback\Transactions\Entities\Transaction;

class TransactionMapper
{
    public static function toDomain(array $row): Transaction
    {
        return new Transaction(
            id: $row['id'],
            userId: $row['user_id'],
            status: $row['status'],
            cashbackAmount: $row['cashback_amount'],
        );
    }

    public static function toPersistence(Transaction $transaction): array
    {
        return [
            'id' => $transaction->id(),
            'user_id' => $transaction->userId(),
            'status' => $transaction->status(),
            'cashback_amount' => $transaction->cashbackAmount(),
        ];
    }
}
