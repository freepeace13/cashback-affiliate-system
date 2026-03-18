<?php

namespace Cashback\Tests\Doubles;

use Cashback\Tests\Doubles\Mappers\TransactionMapper;
use Cashback\Transactions\Repositories\TransactionRepository;
use Cashback\Transactions\Entities\Transaction;
use Illuminate\Support\Collection;

class InMemoryTransactionRepository implements TransactionRepository
{
    private Collection $transactions;

    public function __construct(array $transactions = [])
    {
        $this->transactions = new Collection($transactions);
    }

    public function find($id): ?Transaction
    {
        $existing = $this->transactions->first(fn(array $row) => $row['id'] === $id);

        if (! $existing) {
            return null;
        }

        return TransactionMapper::toDomain($existing);
    }

    public function findByExternalTransactionId($externalTransactionId): ?Transaction
    {
        $existing = $this->transactions->first(
            fn(array $row) => $row['external_transaction_id'] === $externalTransactionId
        );

        if (! $existing) {
            return null;
        }

        return TransactionMapper::toDomain($existing);
    }

    public function listByUserId($userId): array
    {
        return $this->mapToDomain($this->transactions->filter(
            fn(array $row) => $row['user_id'] === $userId
        ));
    }

    protected function mapToDomain(Collection $rows): array
    {
        return $rows->map(
            fn(array $row) => TransactionMapper::toDomain($row)
        )->values()->all();
    }

    public function create(Transaction $transaction): Transaction
    {
        $nextId = $this->transactions->max('id') + 1;

        $this->transactions->push(
            $created = array_replace(
                TransactionMapper::toPersistence($transaction),
                [
                    'id' => $nextId,
                    'created_at' => new \DateTimeImmutable(),
                    'updated_at' => new \DateTimeImmutable(),
                ]
            )
        );

        return TransactionMapper::toDomain($created);
    }

    public function update(Transaction $transaction): void
    {
        $existing = $this->find($transaction->id());

        if (! $existing) {
            throw new \RuntimeException('Transaction not found for update');
        }

        $this->transactions = $this->transactions->map(
            function (array $row) use ($transaction) {
                if ($row['id'] === $transaction->id()) {
                    return TransactionMapper::toPersistence($transaction);
                }

                return $row;
            }
        );
    }
}
