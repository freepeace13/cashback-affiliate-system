<?php

namespace Cashback\Transactions\Repositories;

use Cashback\Transactions\Entities\Transaction;

interface TransactionRepository
{
    public function find($id): ?Transaction;

    public function findByExternalTransactionId($externalTransactionId): ?Transaction;

    public function listByUserId($userId): array;

    public function create(Transaction $transaction): Transaction;

    public function update(Transaction $transaction): void;
}
