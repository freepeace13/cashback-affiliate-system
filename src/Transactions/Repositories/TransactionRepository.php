<?php

namespace Cashback\Transactions\Repositories;

use Cashback\Transactions\Entities\Transaction;
use Cashback\Transactions\ValueObjects\TransactionID;
use Cashback\Transactions\ValueObjects\ExternalTransactionID;

interface TransactionRepository
{
    public function find(TransactionID $id): ?Transaction;

    public function findByExternalTransactionId(ExternalTransactionID $externalTransactionId): ?Transaction;

    public function listByUserId($userId): array;

    public function save(Transaction $transaction): void;
}

