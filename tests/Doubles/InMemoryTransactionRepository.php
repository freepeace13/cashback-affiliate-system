<?php

namespace Cashback\Tests\Doubles;

use Cashback\Transactions\Repositories\TransactionRepository;
use Cashback\Transactions\Entities\Transaction;

class InMemoryTransactionRepository implements TransactionRepository
{
    private $transactions = [];

    public function find($id): ?Transaction
    {
        return $this->transactions[$id] ?? null;
    }

    public function findByExternalTransactionId($externalTransactionId): ?Transaction
    {
        return $this->transactions[$externalTransactionId] ?? null;
    }

    public function listByUserId($userId): array
    {
        return array_filter($this->transactions, fn (Transaction $transaction) => $transaction->userId() === $userId);
    }

    public function save(Transaction $transaction): void
    {
        $this->transactions[$transaction->id()] = $transaction;
    }
}